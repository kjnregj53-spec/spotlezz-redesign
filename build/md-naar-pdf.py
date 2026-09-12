"""Zet een markdown-document om naar een opgemaakte PDF.

Ondersteunt wat er in deze projectdocumenten voorkomt: koppen, alinea's,
tabellen, opsommingen, codeblokken en inline nadruk. Bewust geen algemene
markdown-parser; alleen wat nodig is, zodat de opmaak voorspelbaar blijft.

Gebruik:
    python build/md-naar-pdf.py <invoer.md> <uitvoer.pdf> ["Ondertitel"]
"""

import re
import sys
from reportlab.lib import colors
from reportlab.lib.enums import TA_LEFT
from reportlab.lib.pagesizes import A4
from reportlab.lib.styles import ParagraphStyle, getSampleStyleSheet
from reportlab.lib.units import mm
from reportlab.platypus import (BaseDocTemplate, Frame, KeepTogether, PageTemplate,
                                Paragraph, Spacer, Table, TableStyle)

NACHT = colors.HexColor('#0D0D1A')
KLIK = colors.HexColor('#1B2EFF')
VUUR = colors.HexColor('#FF5500')
GRIJS = colors.HexColor('#5A6072')
LIJN = colors.HexColor('#D8DBE3')
ZACHT = colors.HexColor('#F4F5F7')

BREEDTE, HOOGTE = A4
MARGE = 20 * mm


def stijlen():
    ss = getSampleStyleSheet()
    s = {}
    s['titel'] = ParagraphStyle('titel', parent=ss['Title'], fontName='Helvetica-Bold',
                                fontSize=22, leading=26, textColor=NACHT,
                                alignment=TA_LEFT, spaceAfter=2)
    s['ondertitel'] = ParagraphStyle('ondertitel', parent=ss['Normal'], fontSize=10.5,
                                     leading=15, textColor=GRIJS, spaceAfter=14)
    s['h2'] = ParagraphStyle('h2', parent=ss['Heading2'], fontName='Helvetica-Bold',
                             fontSize=14, leading=18, textColor=NACHT,
                             spaceBefore=16, spaceAfter=7)
    s['h3'] = ParagraphStyle('h3', parent=ss['Heading3'], fontName='Helvetica-Bold',
                             fontSize=11, leading=15, textColor=KLIK,
                             spaceBefore=11, spaceAfter=4)
    s['tekst'] = ParagraphStyle('tekst', parent=ss['Normal'], fontName='Helvetica',
                                fontSize=9.5, leading=14, textColor=colors.HexColor('#22262F'),
                                spaceAfter=7)
    s['bullet'] = ParagraphStyle('bullet', parent=s['tekst'], leftIndent=11,
                                 bulletIndent=2, spaceAfter=3)
    s['cel'] = ParagraphStyle('cel', parent=ss['Normal'], fontName='Helvetica',
                              fontSize=8.5, leading=11.5,
                              textColor=colors.HexColor('#22262F'))
    s['celkop'] = ParagraphStyle('celkop', parent=s['cel'], fontName='Helvetica-Bold',
                                 textColor=colors.white)
    s['code'] = ParagraphStyle('code', parent=ss['Normal'], fontName='Courier',
                               fontSize=8, leading=11, textColor=colors.HexColor('#22262F'))
    return s


def inline(t):
    """Markdown-nadruk naar reportlab-markup."""
    t = (t.replace('&', '&amp;').replace('<', '&lt;').replace('>', '&gt;'))
    t = re.sub(r'\*\*(.+?)\*\*', r'<b>\1</b>', t)
    t = re.sub(r'`(.+?)`', r'<font face="Courier" size="8.5">\1</font>', t)
    return t


def maak_tabel(rijen, s):
    kop, *body = rijen
    kolommen = len(kop)
    data = [[Paragraph(inline(c), s['celkop']) for c in kop]]
    for r in body:
        r = (r + [''] * kolommen)[:kolommen]
        data.append([Paragraph(inline(c), s['cel']) for c in r])

    beschikbaar = BREEDTE - 2 * MARGE
    if kolommen == 2:
        breedtes = [beschikbaar * 0.62, beschikbaar * 0.38]
    elif kolommen == 3:
        breedtes = [beschikbaar * 0.54, beschikbaar * 0.23, beschikbaar * 0.23]
    elif kolommen == 4:
        breedtes = [beschikbaar * 0.46, beschikbaar * 0.18, beschikbaar * 0.18, beschikbaar * 0.18]
    else:
        breedtes = [beschikbaar / kolommen] * kolommen

    t = Table(data, colWidths=breedtes, repeatRows=1, hAlign='LEFT')
    stijl = [
        ('BACKGROUND', (0, 0), (-1, 0), NACHT),
        ('TEXTCOLOR', (0, 0), (-1, 0), colors.white),
        ('VALIGN', (0, 0), (-1, -1), 'TOP'),
        ('TOPPADDING', (0, 0), (-1, -1), 5),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 5),
        ('LEFTPADDING', (0, 0), (-1, -1), 7),
        ('RIGHTPADDING', (0, 0), (-1, -1), 7),
        ('LINEBELOW', (0, 0), (-1, -2), 0.4, LIJN),
        ('BOX', (0, 0), (-1, -1), 0.6, LIJN),
    ]
    for i in range(1, len(data)):
        if i % 2 == 0:
            stijl.append(('BACKGROUND', (0, i), (-1, i), ZACHT))
    t.setStyle(TableStyle(stijl))
    return t


def maak_codeblok(regels, s):
    """Korte regels in kolommen, lange regels onder elkaar."""
    beschikbaar = BREEDTE - 2 * MARGE
    if regels and max(len(r) for r in regels) <= 26 and len(regels) > 6:
        kol = 4
        per = -(-len(regels) // kol)
        raster = [[regels[c * per + r] if c * per + r < len(regels) else ''
                   for c in range(kol)] for r in range(per)]
        data = [[Paragraph(x, s['code']) for x in rij] for rij in raster]
        t = Table(data, colWidths=[beschikbaar / kol] * kol, hAlign='LEFT')
    else:
        data = [[Paragraph(inline(r) or '&nbsp;', s['code'])] for r in regels]
        t = Table(data, colWidths=[beschikbaar], hAlign='LEFT')
    t.setStyle(TableStyle([
        ('BACKGROUND', (0, 0), (-1, -1), ZACHT),
        ('BOX', (0, 0), (-1, -1), 0.6, LIJN),
        ('TOPPADDING', (0, 0), (-1, -1), 2.5),
        ('BOTTOMPADDING', (0, 0), (-1, -1), 2.5),
        ('LEFTPADDING', (0, 0), (-1, -1), 8),
    ]))
    return t


def bouw(md, s):
    verhaal = []
    regels = md.split('\n')
    i = 0
    eerste_kop = True
    while i < len(regels):
        r = regels[i]
        strip = r.strip()

        if not strip or strip == '---':
            i += 1
            continue

        if strip.startswith('```'):
            blok = []
            i += 1
            while i < len(regels) and not regels[i].strip().startswith('```'):
                blok.append(regels[i].rstrip())
                i += 1
            i += 1
            verhaal.append(Spacer(1, 3))
            verhaal.append(maak_codeblok(blok, s))
            verhaal.append(Spacer(1, 9))
            continue

        if strip.startswith('|'):
            rijen = []
            while i < len(regels) and regels[i].strip().startswith('|'):
                cellen = [c.strip() for c in regels[i].strip().strip('|').split('|')]
                if not all(re.fullmatch(r':?-{2,}:?', c) for c in cellen if c):
                    rijen.append(cellen)
                i += 1
            if rijen:
                verhaal.append(Spacer(1, 3))
                verhaal.append(maak_tabel(rijen, s))
                verhaal.append(Spacer(1, 10))
            continue

        if strip.startswith('# '):
            if eerste_kop:
                eerste_kop = False
                i += 1
                continue
            verhaal.append(Paragraph(inline(strip[2:]), s['h2']))
            i += 1
            continue

        if strip.startswith('## '):
            verhaal.append(Paragraph(inline(strip[3:]), s['h2']))
            i += 1
            continue

        if strip.startswith('### '):
            verhaal.append(Paragraph(inline(strip[4:]), s['h3']))
            i += 1
            continue

        if strip.startswith('> '):
            blok = []
            while i < len(regels) and regels[i].strip().startswith('>'):
                blok.append(regels[i].strip().lstrip('>').strip())
                i += 1
            p = Paragraph(inline(' '.join(blok)), s['tekst'])
            t = Table([[p]], colWidths=[BREEDTE - 2 * MARGE], hAlign='LEFT')
            t.setStyle(TableStyle([
                ('LINEBEFORE', (0, 0), (0, -1), 2, VUUR),
                ('LEFTPADDING', (0, 0), (-1, -1), 9),
                ('TOPPADDING', (0, 0), (-1, -1), 3),
                ('BOTTOMPADDING', (0, 0), (-1, -1), 1),
            ]))
            verhaal.append(t)
            verhaal.append(Spacer(1, 8))
            continue

        if re.match(r'^[-*] ', strip):
            items = []
            while i < len(regels) and re.match(r'^[-*] ', regels[i].strip()):
                tekst = regels[i].strip()[2:]
                i += 1
                while i < len(regels) and regels[i].startswith('  ') and regels[i].strip() \
                        and not re.match(r'^[-*] ', regels[i].strip()):
                    tekst += ' ' + regels[i].strip()
                    i += 1
                items.append(Paragraph(inline(tekst), s['bullet'], bulletText='•'))
            verhaal.extend(items)
            verhaal.append(Spacer(1, 6))
            continue

        alinea = [strip]
        i += 1
        while i < len(regels) and regels[i].strip() and not re.match(
                r'^(#{1,3} |\||```|> |[-*] |---)', regels[i].strip()):
            alinea.append(regels[i].strip())
            i += 1
        verhaal.append(Paragraph(inline(' '.join(alinea)), s['tekst']))

    return verhaal


def main():
    invoer, uitvoer = sys.argv[1], sys.argv[2]
    ondertitel = sys.argv[3] if len(sys.argv) > 3 else ''
    md = open(invoer, encoding='utf-8').read()
    s = stijlen()

    titel = 'Document'
    for r in md.split('\n'):
        if r.startswith('# '):
            titel = r[2:].strip()
            break

    def pagina(canvas, doc):
        canvas.saveState()
        if doc.page == 1:
            canvas.setFillColor(NACHT)
            canvas.rect(0, HOOGTE - 12 * mm, BREEDTE, 12 * mm, stroke=0, fill=1)
            canvas.setFillColor(colors.white)
            canvas.setFont('Helvetica-Bold', 8.5)
            canvas.drawString(MARGE, HOOGTE - 8 * mm, 'QLICKR')
            canvas.setFillColor(VUUR)
            canvas.drawString(MARGE + 17 * mm, HOOGTE - 8 * mm, 'x')
            canvas.setFillColor(colors.white)
            canvas.drawString(MARGE + 21 * mm, HOOGTE - 8 * mm, 'SPOTLEZZ')
        canvas.setFillColor(GRIJS)
        canvas.setFont('Helvetica', 7.5)
        canvas.drawString(MARGE, 12 * mm, titel)
        canvas.drawRightString(BREEDTE - MARGE, 12 * mm, str(doc.page))
        canvas.setStrokeColor(LIJN)
        canvas.setLineWidth(0.5)
        canvas.line(MARGE, 15 * mm, BREEDTE - MARGE, 15 * mm)
        canvas.restoreState()

    doc = BaseDocTemplate(uitvoer, pagesize=A4,
                          leftMargin=MARGE, rightMargin=MARGE,
                          topMargin=MARGE, bottomMargin=22 * mm,
                          title=titel, author='Qlickr')
    frame1 = Frame(MARGE, 22 * mm, BREEDTE - 2 * MARGE,
                   HOOGTE - 22 * mm - 26 * mm, id='eerste')
    frame = Frame(MARGE, 22 * mm, BREEDTE - 2 * MARGE,
                  HOOGTE - 22 * mm - MARGE, id='normaal')
    doc.addPageTemplates([
        PageTemplate(id='eerste', frames=[frame1], onPage=pagina),
        PageTemplate(id='normaal', frames=[frame], onPage=pagina),
    ])

    verhaal = [Paragraph(titel, s['titel'])]
    if ondertitel:
        verhaal.append(Paragraph(ondertitel, s['ondertitel']))
    verhaal.extend(bouw(md, s))
    doc.build(verhaal)
    print(f'geschreven: {uitvoer}')


if __name__ == '__main__':
    main()
