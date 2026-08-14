/**
 * Teksten voor de locatielaag.
 *
 * De doorway-regel uit wireframe-4 is hier leidend: elke pagina heeft eigen
 * geografische inhoud, eigen werkgebiedtekst en eigen vragen. Geen enkele
 * alinea is een zoek-en-vervang van een andere stad.
 *
 * LET OP: Spotlezz heeft een bezoekadres in Amsterdam. Op de andere
 * stadspagina's staat dat adres expliciet als hoofdkantoor benoemd en niet als
 * lokale vestiging. Zie build/TE-CONTROLEREN.md.
 */

export const LOCATION_CONTENT = {
  /* ================================================================ */
  almere: {
    h1: 'Schoonmaakbedrijf Almere',
    title: 'Schoonmaakbedrijf Almere voor kantoren, hotels en VvE | Spotlezz',
    description: 'Schoonmaakbedrijf in Almere met vaste teams in Stad, Buiten, Haven en Poort. Binnen 12 uur een afspraak. Bekijk ons werkgebied en lokale klanten.',
    intro: 'Almere is onze thuisbasis. Onze hoofdvestiging staat aan het Spinnakerplantsoen en wij rijden hier dagelijks door alle vier de stadsdelen. De bedrijventerreinen, de aanrijtijden en de spitsdrukte op de Hogering kennen wij uit ervaring in plaats van uit een routeplanner.',
    answer:
      'Spotlezz is een zakelijk schoonmaakbedrijf met de hoofdvestiging in Almere en werkt in Almere Stad, Almere Buiten, Almere Haven en Almere Poort. Wij maken kantoren, hotels, showrooms, sportscholen, kinderopvang en VvE-complexen schoon met vaste teams. Binnen 12 uur na uw aanvraag staat er een afspraak.',
    facts: [
      { value: '4 stadsdelen', label: 'Dekking' },
      { value: '< 12 uur', label: 'Reactietijd' },
      { value: '< 20 min', label: 'Aanrijtijd binnen stad' },
      { value: '87', label: 'Beoordelingen' },
    ],
    topServices: ['kantoor-schoonmaak', 'vve-schoonmaak', 'kinderopvang-schoonmaak'],
    caseSlug: 'kobelco',
    review: 'Sinds Spotlezz bij ons in Almere schoonmaakt is het eindelijk consequent schoon. Ze reageren snel en de vaste schoonmaakster is een verademing vergeleken met ons vorige bureau.',
    reviewer: { name: 'Martijn van den Berg', role: 'Office Manager', city: 'Almere Poort', initial: 'M' },
    team: {
      name: 'Sanne Verhoeven',
      role: 'Teamleider Almere',
      quote: 'Ik ken de meeste panden hier van binnen. Dat scheelt bij een spoedmelding: ik weet welke sleutel waar hangt en welk team het dichtst in de buurt zit.',
    },
    areaHeading: 'Ons werkgebied in Almere',
    area: [
      'Almere is met ruim tweehonderdduizend inwoners de grootste stad van Flevoland en tegelijk een van de meest verspreide. Van De Steiger in Almere Haven naar de bedrijventerreinen in Almere Buiten is bijna vijftien kilometer. Voor een schoonmaakbedrijf betekent dat iets simpels: je kunt niet vanuit een punt de hele stad bedienen zonder dat de reistijd in de prijs gaat zitten. Wij hebben Almere daarom in vier routes verdeeld die elk een stadsdeel bestrijken.',
      'Het zwaartepunt van ons werk ligt op de kantorenlocaties rond het centrum. Het Stadshart en het aangrenzende Randstad-gebied hebben de hoogste concentratie kantoren van de stad, met veel panden waar meerdere organisaties een verdieping huren. Daar werken wij vrijwel altijd in de vroege ochtend, tussen zes en half negen, omdat de gedeelde entrees en liften dan vrij zijn en er in de kantoortuinen niemand zit.',
      'Op de bedrijventerreinen ligt dat anders. Veluwsekant, Gooisekant, Markerkant, Sallandsekant en Hollandsekant hebben meer zelfstandige panden met een eigen ingang en een eigen sleutel. Daar is een avondronde vaak praktischer, en soms zelfs een ronde tijdens werktijd omdat er weinig kantoorpersoneel zit dat er last van heeft. Op De Vaart en Poldervlak, in de richting van Almere Buiten, zien wij meer bedrijfshallen met een klein kantoorgedeelte. Dat vraagt om een andere verhouding in het werkprogramma: minder werkplekken, meer sanitair en kantine per persoon.',
      'De aanrijtijden binnen de stad zijn gunstig zolang je de spits kent. De Hogering en de Waterlandseweg lopen tussen half acht en negen uur vast richting de A6, en aan het eind van de middag in omgekeerde richting. Onze ochtendploegen zijn daarom voor zeven uur op locatie en onze avondploegen starten na zes uur. Binnen die vensters halen wij vrijwel elk adres in Almere binnen twintig minuten vanaf het vorige.',
      'Wij werken in Almere voor kantoren, kinderopvanglocaties en VvE-complexen. Dat laatste is in deze stad een grotere categorie dan elders: Almere heeft veel gestapelde nieuwbouw uit de jaren tachtig en negentig met gemeenschappelijke trappenhuizen, galerijen en bergingsgangen die onder een VvE vallen. Voor die complexen werken wij met een vaste dag en een logboek in de hal, zodat bewoners meldingen kwijt kunnen zonder dat het bestuur ertussen hoeft te zitten.',
      'Elk stadsdeel heeft zijn eigen pagina met wat wij daar precies doen. Almere Stad voor de kantoren en het centrum, Almere Buiten voor de bedrijventerreinen en de kinderopvang, Almere Haven voor de kleinere panden en de horeca aan het water, en Almere Poort voor de nieuwbouw en de scholen.',
    ],
    faq: [
      { q: 'Hoe snel zijn jullie in Almere ter plaatse?',
        a: 'Binnen 12 uur staat er een afspraak. Bij een calamiteit bij een bestaande klant zijn wij binnen twee uur ter plaatse, omdat er altijd een team in de stad rijdt.' },
      { q: 'In welke wijken van Almere werken jullie?',
        a: 'In alle vier de stadsdelen: Almere Stad, Almere Buiten, Almere Haven en Almere Poort. Wij rijden vier routes zodat de reistijd niet in uw tarief terechtkomt.' },
      { q: 'Werken jullie ook in de avond in Almere?',
        a: 'Ja. Op de bedrijventerreinen werken wij meestal in de avond en in het centrum juist voor kantoortijd, omdat de gedeelde entrees en liften dan vrij zijn.' },
      { q: 'Doen jullie ook VvE-complexen in Almere?',
        a: 'Ja, dat is hier een van onze grotere categorieën. Almere heeft veel gestapelde bouw met gemeenschappelijke trappenhuizen en bergingsgangen. Wij werken daar met een vaste dag en een logboek in de hal.' },
    ],
  },

  /* ================================================================ */
  lelystad: {
    h1: 'Schoonmaakbedrijf Lelystad',
    title: 'Schoonmaakbedrijf Lelystad voor kantoren en bedrijven | Spotlezz',
    description: 'Schoonmaakbedrijf in Lelystad voor kantoren, bedrijfspanden en publieke gebouwen. Vaste teams, binnen 12 uur een afspraak.',
    intro: 'Lelystad ligt op een half uur van onze thuisbasis en heeft een heel ander profiel dan Almere: meer overheid, meer logistiek en grotere kavels. Wij rijden er dagelijks en plannen de routes rond de spits op de A6.',
    answer:
      'Spotlezz werkt in Lelystad voor kantoren, bedrijfspanden, publieke gebouwen en VvE-complexen. Wij combineren afspraken in Lelystad tot vaste routedagen, zodat de reistijd vanaf Almere niet in uw tarief terechtkomt. Binnen 12 uur na uw aanvraag staat er een afspraak.',
    facts: [
      { value: '30 min', label: 'Vanaf Almere' },
      { value: '< 12 uur', label: 'Reactietijd' },
      { value: 'Vaste routedagen', label: 'Planning' },
      { value: '87', label: 'Beoordelingen' },
    ],
    topServices: ['kantoor-schoonmaak', 'vloeronderhoud', 'hygieneservice'],
    caseSlug: 'kuchentreff',
    review: 'Heel fijn team dat goed meedenkt. We hebben nooit meer klachten over de toiletten of de keuken. Een echte aanrader voor elk kantoor.',
    reviewer: { name: 'Sarah de Wit', role: 'Facility Manager', city: 'Lelystad', initial: 'S' },
    team: {
      name: 'Dennis Kok',
      role: 'Teamleider Lelystad en Noordoostpolder',
      quote: 'Lelystad is qua afstanden overzichtelijk maar de panden zijn groter. Ik plan hier liever twee grote adressen op een dag dan zes kleine, dan houd je de kwaliteit hoog.',
    },
    areaHeading: 'Ons werkgebied in Lelystad',
    area: [
      'Lelystad heeft voor een stad van bijna tachtigduizend inwoners een opvallend groot aandeel kantoormeters. Dat komt door de bestuurlijke functie: het provinciehuis van Flevoland, de rechtbank, Rijkswaterstaat en een reeks uitvoeringsorganisaties zitten hier. Die gebouwen hebben een ander schoonmaakprofiel dan een commercieel kantoor. Er zijn meer vergaderruimtes per medewerker, meer publieksruimte en strengere eisen aan toegang en sleutelbeheer.',
      'Daarnaast is Lelystad sterk in logistiek. Op Flevopoort, Larserpoort en Oostervaart staan distributiecentra en productiebedrijven met grote hallen en een relatief klein kantoorgedeelte. Voor die panden ligt het accent van het werkprogramma op sanitair, kleedruimtes en kantine in plaats van op werkplekken. Wij rekenen daar per persoon en niet per vierkante meter, omdat honderd man in een hal meer sanitaire belasting geeft dan honderd man op een kantoorvloer.',
      'Rond Lelystad Airport en het bijbehorende businesspark zit een derde categorie: kleinere, nieuwere panden waar bedrijven een unit huren. Die vragen om korte, frequente rondes en om flexibiliteit, want de bezetting wisselt er sneller dan elders.',
      'De reistijd vanaf Almere is het punt dat de planning bepaalt. Over de A6 is het ongeveer dertig minuten, maar tussen zeven en negen uur richting Almere en Amsterdam loopt dat traject vol. Wij plannen Lelystad daarom op vaste routedagen en bundelen alle afspraken in de stad op diezelfde dagen. Daardoor rijdt een team hier een volledige dag in plaats van heen en weer, en betaalt u niet mee aan reistijd die met betere planning te vermijden was.',
      'Binnen de stad zelf zijn de afstanden klein. Van Noordersluis naar het Stadshart of naar Batavia Stad is het nergens meer dan een kwartier. Dat betekent dat wij op een routedag zonder problemen meerdere panden kunnen bedienen en dat een spoedmelding op zo een dag vrijwel altijd dezelfde dag nog opgelost wordt.',
      'Wij werken in Lelystad vooral voor kantoren en bedrijfspanden. Vloeronderhoud is hier een grotere post dan gemiddeld, doordat de hallen en de publieke ruimtes zwaar belast worden en er veel zand van buiten naar binnen komt. Wij nemen dat als aparte regel op in de offerte, met een eigen frequentie per zone.',
    ],
    faq: [
      { q: 'Rekenen jullie voorrijkosten voor Lelystad?',
        a: 'Nee. Wij bundelen alle afspraken in Lelystad op vaste routedagen, zodat een team hier een volledige dag rijdt. Daardoor zit er geen losse reistijd in uw tarief.' },
      { q: 'Hoe snel zijn jullie in Lelystad ter plaatse?',
        a: 'Binnen 12 uur staat er een afspraak. Op een routedag lossen wij een spoedmelding meestal dezelfde dag nog op.' },
      { q: 'Werken jullie ook voor overheidsgebouwen in Lelystad?',
        a: 'Ja. Wij zijn bekend met de eisen die daarbij horen op het gebied van toegang, sleutelbeheer en het vastleggen van uitgevoerde handelingen.' },
      { q: 'Doen jullie ook grote hallen en distributiecentra?',
        a: 'Ja. Bij dat type pand ligt het accent op sanitair, kleedruimtes en kantine. Wij rekenen daar per persoon in plaats van per vierkante meter, omdat dat de werkelijke belasting beter benadert.' },
    ],
  },

  /* ================================================================ */
  amsterdam: {
    h1: 'Schoonmaakbedrijf Amsterdam',
    title: 'Schoonmaakbedrijf Amsterdam voor kantoren en hotels | Spotlezz',
    description: 'Schoonmaakbedrijf in Amsterdam voor kantoren, hotels en showrooms. Vaste teams vanuit Almere, binnen 12 uur een afspraak.',
    intro: 'Wij werken in Amsterdam voor kantoren, hotels en showrooms. De stad vraagt om andere planning dan Flevoland: laden en lossen, venstertijden en betaald parkeren bepalen mede hoe een ronde eruitziet.',
    answer:
      'Spotlezz werkt in Amsterdam voor kantoren, hotels, showrooms en bedrijfspanden. Onze teams rijden vanuit de hoofdvestiging in Almere en werken per stadsdeel in vaste clusters. Wij stemmen de rondes af op venstertijden en bereikbaarheid, en binnen 12 uur na uw aanvraag staat er een afspraak.',
    facts: [
      { value: '30 min', label: 'Vanaf Almere' },
      { value: '< 12 uur', label: 'Reactietijd' },
      { value: 'Venstertijden', label: 'Ingepland' },
      { value: '87', label: 'Beoordelingen' },
    ],
    topServices: ['kantoor-schoonmaak', 'hotel-schoonmaak', 'glasbewassing'],
    caseSlug: 'kuchentreff',
    review: 'Topkwaliteit en altijd netjes op tijd. Onze medewerkers werken een stuk prettiger in een schoon kantoor. Ga zo door Spotlezz!',
    reviewer: { name: 'Jan-Willem Peters', role: 'Directeur', city: 'Amsterdam', initial: 'J' },
    team: {
      name: 'Youssef Ait Bella',
      role: 'Teamleider Amsterdam',
      quote: 'In Amsterdam is de planning het halve werk. Als je in Zuidoost begint en in Sloterdijk eindigt, of andersom, scheelt dat op een dag zo drie kwartier rijden.',
    },
    areaHeading: 'Ons werkgebied in Amsterdam',
    area: [
      'Amsterdam is geen stad met een schoonmaakprofiel maar met een stuk of vijf. De kantorenconcentraties liggen ver uit elkaar en werken elk anders. Zuidas heeft grote, moderne panden met eigen facilitaire organisaties en strenge toegangsprocedures. Sloterdijk en het Teleportgebied hebben meer verhuur per verdieping en veel gedeelde voorzieningen. Amstel III en het gebied rond de Arena in Zuidoost combineren kantoor met showroom en horeca. En in het centrum zitten kleinere panden in oude gebouwen waar bijna niets standaard is.',
      'Voor ons betekent dat vooral dat de volgorde van een route bepaalt of een dag klopt. Wij plannen per dagdeel binnen een cluster in plaats van kriskras door de stad. Een team dat in Zuidoost begint werkt daar de ochtend af en gaat pas daarna naar een ander cluster, nooit halverwege de ochtend van de ring naar de andere kant.',
      'Bereikbaarheid is het tweede planningspunt. In grote delen van de stad geldt betaald parkeren en op sommige plekken een venstertijd voor laden en lossen. Voor het aanvoeren van machines bij vloeronderhoud of een glasbewassing met hoogwerker moet dat vooraf geregeld zijn, inclusief een eventuele vergunning voor het plaatsen op de openbare weg. Bij panden in het centrum plannen wij dat soort werk daarom bij voorkeur in het weekend.',
      'Hotels zijn in Amsterdam een aparte tak. Daar werkt de kamerschoonmaak in het venster tussen check-out en check-in, en de publieke ruimtes in de rustige uren van de dag. Bij een hoge bezetting schalen wij het team op die dag op in plaats van de rondes in te korten, want een half gedane kamer valt een gast eerder op dan een kamer die een uur later klaar is.',
      'Voor showrooms in en rond de stad geldt dat glas het belangrijkste onderdeel is. Grote glaspartijen aan een drukke weg vervuilen hier sneller dan in Flevoland, simpelweg door de verkeersintensiteit. Wij rijden op die adressen een kortere glascyclus dan wij elders zouden voorstellen.',
      'Onze hoofdvestiging staat in Almere, aan het Spinnakerplantsoen. Vanuit daar rijden de teams naar Amsterdam. Een intake doen wij altijd bij u op locatie en niet bij ons, omdat wij een offerte pas kunnen onderbouwen als wij het pand hebben gezien.',
    ],
    faq: [
      { q: 'Hebben jullie een vestiging in Amsterdam?',
        a: 'Nee, onze hoofdvestiging staat in Almere aan het Spinnakerplantsoen. Onze teams rijden vanuit daar naar Amsterdam. Intakes doen wij altijd bij u op locatie, omdat wij een offerte pas kunnen onderbouwen als wij het pand hebben gezien.' },
      { q: 'Hoe gaan jullie om met venstertijden en parkeren?',
        a: 'Voor reguliere rondes is dat zelden een probleem. Voor werk met machines, zoals vloeronderhoud of glasbewassing met een hoogwerker, regelen wij de toegang vooraf en plannen wij in het centrum bij voorkeur in het weekend.' },
      { q: 'Werken jullie ook voor hotels in Amsterdam?',
        a: 'Ja. Wij werken tussen check-out en check-in voor de kamers en in de rustige uren voor de publieke ruimtes. Bij hoge bezetting zetten wij meer mensen in plaats van kortere rondes in.' },
      { q: 'In welke delen van Amsterdam werken jullie?',
        a: 'Wij werken door de hele stad en plannen per cluster: Zuidas, Sloterdijk en Teleport, Zuidoost en Amstel III, en het centrum. Binnen een dagdeel blijft een team in hetzelfde cluster.' },
    ],
  },

  /* ================================================================ */
  amersfoort: {
    h1: 'Schoonmaakbedrijf Amersfoort',
    title: 'Schoonmaakbedrijf Amersfoort voor kantoren en bedrijven | Spotlezz',
    description: 'Schoonmaakbedrijf in Amersfoort voor kantoren en bedrijfspanden op De Hoef, Calveen, Vathorst en De Isselt. Binnen 12 uur een afspraak.',
    intro: 'Amersfoort is de zuidgrens van ons werkgebied. Wij werken hier op de kantorenlocaties rond het station en op de bedrijventerreinen aan de noordkant, met vaste routedagen zodat de rit vanaf Almere niet in uw tarief zit.',
    answer:
      'Spotlezz werkt in Amersfoort voor kantoren en bedrijfspanden, met de nadruk op De Hoef, Calveen, Vathorst en De Isselt. Wij bundelen afspraken op vaste routedagen via de A27 en A1. Binnen 12 uur na uw aanvraag staat er een afspraak.',
    facts: [
      { value: '45 min', label: 'Vanaf Almere' },
      { value: '< 12 uur', label: 'Reactietijd' },
      { value: 'Vaste routedagen', label: 'Planning' },
      { value: '87', label: 'Beoordelingen' },
    ],
    topServices: ['kantoor-schoonmaak', 'glasbewassing', 'vloeronderhoud'],
    caseSlug: 'kobelco',
    review: 'Sinds Spotlezz bij ons de kantoorschoonmaak verzorgt is het eindelijk consequent schoon. Ze reageren snel en de vaste schoonmaakster is een verademing.',
    reviewer: { name: 'Martijn van den Berg', role: 'Office Manager', city: 'Amersfoort', initial: 'M' },
    team: {
      name: 'Sanne Verhoeven',
      role: 'Teamleider Almere en Amersfoort',
      quote: 'Amersfoort doen wij op vaste dagen. Dat werkt beter dan er af en toe heen rijden, want dan kun je een spoedmelding op diezelfde dag gewoon meenemen.',
    },
    areaHeading: 'Ons werkgebied in Amersfoort',
    area: [
      'Amersfoort heeft zijn kantoren geconcentreerd op een paar goed afgebakende plekken, en dat maakt de stad voor ons goed planbaar. De Hoef bij het station is de grootste kantorenlocatie, met veel panden waar meerdere organisaties huren. Daar werken wij vrijwel altijd voor kantoortijd, omdat de gedeelde entrees, liften en pantry\'s dan vrij zijn en de rondes elkaar niet in de weg zitten.',
      'Calveen en Vathorst aan de noordkant hebben een ander karakter. Daar staan nieuwere, zelfstandige panden met een eigen ingang en vaak een eigen parkeerterrein. Dat maakt een avondronde praktisch, en omdat er geen gedeelde voorzieningen zijn is het werkprogramma er eenvoudiger op te stellen. De Isselt en Wieken-Vinkenhoef zijn de klassieke bedrijventerreinen, met bedrijfshallen en een kantoorgedeelte ervoor. Daar geldt hetzelfde als in Lelystad: de belasting zit in het sanitair en de kantine en niet op de kantoorvloer.',
      'De rit vanaf Almere gaat via de A27 en de A1 en duurt buiten de spits ongeveer drie kwartier. In de spits loopt met name het traject bij knooppunt Eemnes vast, in beide richtingen. Wij plannen Amersfoort daarom op vaste routedagen en zorgen dat een team hier een volledige dag werkt. Zo betaalt u niet mee aan een rit die met betere planning te vermijden was, en kunnen wij een spoedmelding op een routedag dezelfde dag nog oppakken.',
      'Binnen de stad zijn de afstanden klein. Van De Hoef naar Vathorst is het een kwartier, en de rest van de kantorenlocaties ligt daartussenin. Op een routedag bedienen wij daarom zonder problemen meerdere panden zonder dat de kwaliteit onder de planning lijdt.',
      'Wat in Amersfoort vaker voorkomt dan in Flevoland zijn kantoren in oudere panden in en rond de binnenstad. Die hebben smallere trappen, geen lift en soms monumentale details waar niet met standaardmiddelen op gewerkt kan worden. Wij nemen dat mee in de intake, want het bepaalt zowel de tijd per ronde als het materiaal dat wij meenemen.',
      'Glasbewassing is hier een grotere post dan gemiddeld, doordat veel panden op De Hoef en Calveen grote glaspartijen hebben die vanaf de weg goed zichtbaar zijn. Wij stellen daar meestal een cyclus van vier weken voor aan de straatzijde en acht weken aan de achterzijde.',
    ],
    faq: [
      { q: 'Rekenen jullie voorrijkosten voor Amersfoort?',
        a: 'Nee. Wij bundelen alle afspraken in Amersfoort op vaste routedagen, zodat een team hier een volledige dag rijdt en er geen losse reistijd in uw tarief zit.' },
      { q: 'Op welke bedrijventerreinen in Amersfoort werken jullie?',
        a: 'Vooral op De Hoef, Calveen, Vathorst, De Isselt en Wieken-Vinkenhoef. Rond het station werken wij voor kantoortijd, op de terreinen aan de noordkant meestal in de avond.' },
      { q: 'Hoe snel zijn jullie in Amersfoort ter plaatse?',
        a: 'Binnen 12 uur staat er een afspraak. Op een routedag pakken wij een spoedmelding meestal dezelfde dag nog op.' },
      { q: 'Werken jullie ook in oudere panden in de binnenstad?',
        a: 'Ja. Wij nemen bij de intake mee dat er smallere trappen, geen lift of monumentale details kunnen zijn, omdat dat zowel de tijd per ronde als het materiaal bepaalt.' },
    ],
  },

  /* ================================================================ */
  /* Wijkpagina's Almere                                              */
  /* ================================================================ */

  'almere-stad': {
    h1: 'Schoonmaakbedrijf Almere Stad',
    title: 'Schoonmaakbedrijf Almere Stad, centrum en Randstad | Spotlezz',
    description: 'Schoonmaak voor kantoren in Almere Stad, het Stadshart en het Randstad-gebied. Ochtendrondes voor kantoortijd, vaste teams.',
    intro: 'Almere Stad is het kantorenhart van de stad. Wij werken hier vrijwel altijd voor kantoortijd, omdat de gedeelde entrees en liften in de verzamelpanden dan vrij zijn.',
    answer:
      'In Almere Stad werkt Spotlezz voor kantoren in het Stadshart, het Randstad-gebied en op de bedrijventerreinen Veluwsekant, Gooisekant en Markerkant. Wij rijden hier een ochtendroute tussen zes en half negen, zodat het werk klaar is voordat uw medewerkers binnenkomen.',
    facts: [
      { value: '06:00 tot 08:30', label: 'Ochtendroute' },
      { value: '< 12 uur', label: 'Reactietijd' },
      { value: 'Verzamelpanden', label: 'Specialisme' },
      { value: '87', label: 'Beoordelingen' },
    ],
    topServices: ['kantoor-schoonmaak', 'glasbewassing', 'hygieneservice'],
    caseSlug: 'kobelco',
    review: 'Sinds Spotlezz bij ons de kantoorschoonmaak verzorgt is het eindelijk consequent schoon. Ze reageren snel en de vaste schoonmaakster is een verademing.',
    reviewer: { name: 'Martijn van den Berg', role: 'Office Manager', city: 'Almere Stad', initial: 'M' },
    team: {
      name: 'Sanne Verhoeven',
      role: 'Teamleider Almere',
      quote: 'In het centrum draait alles om de volgorde. Wij doen de gedeelde ruimtes als eerste, dan de verdiepingen. Anders sta je met je kar in de lift als de eerste mensen binnenkomen.',
    },
    areaHeading: 'Wat wij doen in Almere Stad',
    area: [
      'Almere Stad is het grootste stadsdeel en tegelijk het dichtst bebouwde. Rond het Stadshart en het aangrenzende Randstad-gebied staat de hoogste concentratie kantoormeters van heel Flevoland. Veel van die panden zijn verzamelgebouwen waar meerdere organisaties een of twee verdiepingen huren, met een gedeelde entree, gedeelde liften en gedeeld sanitair per verdieping.',
      'Dat type pand vraagt om een specifieke werkvolgorde. Wij beginnen altijd met de gedeelde ruimtes: entree, liften, trappenhuis en het sanitair op de verdiepingen. Pas daarna gaan wij de kantoorruimtes zelf in. Andersom werken betekent dat je met materiaal in de lift staat op het moment dat de eerste medewerkers binnenkomen, en dat is precies het beeld dat een kantoorgebouw niet wil.',
      'Op de bedrijventerreinen Veluwsekant, Gooisekant en Markerkant zitten meer zelfstandige panden met een eigen ingang. Daar is de ochtend niet per se nodig en werken wij vaker in de avond, wat ook rustiger inplant. Voor bedrijven met een showroom aan de straatzijde nemen wij het glas mee in een kortere cyclus dan de rest van het pand, omdat dat vanaf de weg het visitekaartje is.',
      'De woonwijken in Almere Stad, van Filmwijk en Muziekwijk tot Parkwijk en Waterwijk, tellen voor ons vooral mee via de VvE-complexen en de kinderopvanglocaties. Die laatste categorie is hier omvangrijk. Voor kinderopvang werken wij met gescheiden materiaal per ruimte en met kindveilige middelen, en leggen wij de uitgevoerde handelingen vast zodat de locatiemanager dat bij een GGD-inspectie kan laten zien.',
      'Almere Stad is voor ons het gemakkelijkst bereikbare stadsdeel, met vrijwel alle adressen binnen tien minuten van elkaar. Een spoedmelding hier lossen wij bijna altijd dezelfde dag op.',
    ],
    faq: [
      { q: 'Werken jullie in verzamelpanden ook voor de gedeelde ruimtes?',
        a: 'Ja. Wij doen zowel de gedeelde entree, liften en trappenhuizen als de kantoorruimtes zelf. Vaak zijn dat twee opdrachtgevers, de VvE of beheerder en de huurder, en dan houden wij dat gescheiden in de offerte.' },
      { q: 'Hoe vroeg beginnen jullie in het centrum?',
        a: 'Onze ochtendroute in Almere Stad start om zes uur en is rond half negen klaar. Zo is het werk gedaan voordat uw medewerkers binnenkomen.' },
      { q: 'Doen jullie ook kinderopvang in Almere Stad?',
        a: 'Ja, dat is hier een grote categorie. Wij werken met kindveilige middelen en gescheiden materiaal per ruimte, en leggen de handelingen vast voor de GGD-inspectie.' },
    ],
  },

  'almere-buiten': {
    h1: 'Schoonmaakbedrijf Almere Buiten',
    title: 'Schoonmaakbedrijf Almere Buiten en Poldervlak | Spotlezz',
    description: 'Schoonmaak in Almere Buiten voor bedrijfspanden op Poldervlak en De Vaart, kinderopvang en VvE. Vaste teams, avondrondes mogelijk.',
    intro: 'Almere Buiten heeft de meeste bedrijfshallen van de stad en tegelijk veel kinderopvang. Twee heel verschillende soorten werk, die wij hier op dezelfde route combineren.',
    answer:
      'In Almere Buiten werkt Spotlezz voor bedrijfspanden op Poldervlak en De Vaart, voor kinderopvanglocaties en voor VvE-complexen. Bij bedrijfshallen ligt het accent op sanitair, kleedruimte en kantine, en daar rekenen wij per persoon in plaats van per vierkante meter.',
    facts: [
      { value: 'Hal en kantoor', label: 'Combinatie' },
      { value: '< 12 uur', label: 'Reactietijd' },
      { value: 'Avondrondes', label: 'Mogelijk' },
      { value: '87', label: 'Beoordelingen' },
    ],
    topServices: ['kantoor-schoonmaak', 'kinderopvang-schoonmaak', 'vloeronderhoud'],
    caseSlug: 'arena-gym',
    review: 'Ze werken met producten die veilig zijn voor de kinderen en houden zich aan ons protocol. De GGD-inspectie had geen enkele opmerking.',
    reviewer: { name: 'Linda Hoekstra', role: 'Locatiemanager', city: 'Almere Buiten', initial: 'L' },
    team: {
      name: 'Sanne Verhoeven',
      role: 'Teamleider Almere',
      quote: 'In Buiten heb je hallen waar honderd man werkt met twee toiletten en een kantine. Als je daar per vierkante meter rekent, klopt er niets van. Je moet naar de mensen kijken.',
    },
    areaHeading: 'Wat wij doen in Almere Buiten',
    area: [
      'Almere Buiten is het stadsdeel met het grootste aandeel bedrijfsruimte. Op Poldervlak en op De Vaart staan bedrijfshallen, productiebedrijven en groothandels, vrijwel altijd met een klein kantoorgedeelte aan de voorzijde. Dat type pand heeft een schoonmaakprofiel dat afwijkt van een gewoon kantoor: er zijn weinig werkplekken, maar het sanitair, de kleedruimte en de kantine worden zwaar belast door een groot aantal mensen.',
      'Wij rekenen bij dit soort panden daarom per persoon en niet per vierkante meter. Honderd medewerkers in een hal van drieduizend vierkante meter geven meer sanitaire belasting dan honderd mensen op een kantoorvloer van tweeduizend meter, terwijl de vloer zelf juist minder aandacht nodig heeft. Wie hier per meter offreert, komt structureel te laag uit op sanitair en te hoog op de hal.',
      'Vloeronderhoud speelt in Buiten een grotere rol dan elders in Almere. Er komt veel zand en gruis van buiten naar binnen via de laad- en losdeuren, en dat schuurt de beschermlaag van de vloer weg. Wij nemen daarom bij dit soort panden de entree en de looproutes als aparte zone op, met een hogere frequentie dan de rest.',
      'Daarnaast heeft Almere Buiten veel kinderopvang. De wijken rond het winkelcentrum en in de Regenboogbuurt, Eilandenbuurt en Faunabuurt hebben een jonge bevolkingsopbouw en navenant veel opvanglocaties. Voor die locaties werken wij met kindveilige middelen en met gescheiden materiaal per ruimte om kruisbesmetting te voorkomen. Wij leggen de uitgevoerde handelingen vast, zodat de locatiemanager dat bij een inspectie kan overleggen.',
      'De combinatie van bedrijfspanden en opvanglocaties op een route werkt in de praktijk goed. Opvang moet vroeg klaar zijn, meestal voor half acht, en de bedrijfspanden kunnen juist in de avond. Daardoor kan hetzelfde team hier twee dagdelen vullen zonder ver te rijden.',
    ],
    faq: [
      { q: 'Hoe offreren jullie een bedrijfshal met een klein kantoor?',
        a: 'Per persoon in plaats van per vierkante meter. De belasting zit bij dat type pand in het sanitair, de kleedruimte en de kantine, en die schaalt mee met het aantal mensen en niet met het vloeroppervlak.' },
      { q: 'Doen jullie ook de laad- en losruimte?',
        a: 'Ja, meestal als aparte zone met een eigen frequentie. Daar komt het meeste zand binnen, en dat is de belangrijkste oorzaak van slijtage aan de vloer in de rest van het pand.' },
      { q: 'Werken jullie voor kinderopvang in Almere Buiten?',
        a: 'Ja. Wij werken met kindveilige middelen en gescheiden materiaal per ruimte, en leggen de handelingen vast zodat u dat bij een GGD-inspectie kunt laten zien.' },
    ],
  },

  'almere-haven': {
    h1: 'Schoonmaakbedrijf Almere Haven',
    title: 'Schoonmaakbedrijf Almere Haven en De Steiger | Spotlezz',
    description: 'Schoonmaak in Almere Haven voor kleinere kantoren, horeca aan het water, VvE en bedrijfspanden op De Steiger.',
    intro: 'Almere Haven is het oudste stadsdeel en dat zie je aan de panden: kleiner, lager en dichter op elkaar. Wij werken hier voor kleinere kantoren, horeca aan de haven en de VvE-complexen in de oudere bouw.',
    answer:
      'In Almere Haven werkt Spotlezz voor kleinere kantoorpanden, horeca rond de jachthaven, VvE-complexen en bedrijven op bedrijventerrein De Steiger. De schaal is hier kleiner dan elders in Almere, waardoor kortere en frequentere rondes vaak beter werken dan een lange wekelijkse beurt.',
    facts: [
      { value: 'Oudste stadsdeel', label: 'Bouwjaar vanaf 1976' },
      { value: '< 12 uur', label: 'Reactietijd' },
      { value: 'Korte rondes', label: 'Werkwijze' },
      { value: '87', label: 'Beoordelingen' },
    ],
    topServices: ['vve-schoonmaak', 'kantoor-schoonmaak', 'hygieneservice'],
    caseSlug: 'kuchentreff',
    review: 'Vaste dag, vaste schoonmaker en een logboek in de hal. Voor het eerst hoeven wij als bestuur er niet meer achteraan te bellen.',
    reviewer: { name: 'Peter Vermeulen', role: 'Bestuurder VvE', city: 'Almere Haven', initial: 'P' },
    team: {
      name: 'Sanne Verhoeven',
      role: 'Teamleider Almere',
      quote: 'Haven is een stadsdeel van kleine adressen dicht bij elkaar. Twee keer per week een korte ronde werkt daar beter dan een keer per week een lange, en het kost vaak niet eens meer.',
    },
    areaHeading: 'Wat wij doen in Almere Haven',
    area: [
      'Almere Haven is het eerste stadsdeel dat werd gebouwd en heeft daardoor een heel andere maat dan de rest van de stad. De bebouwing is laag, de straten zijn smal en de panden zijn kleiner. Voor ons betekent dat: veel adressen die elk niet veel tijd kosten, dicht bij elkaar.',
      'Bij dat profiel werkt een andere frequentie dan elders. Voor een klein kantoor van honderdvijftig vierkante meter is twee keer per week een korte ronde bijna altijd beter dan een keer per week een lange. Het pand zakt nooit ver weg, het sanitair blijft op orde, en omdat de reistijd tussen adressen hier minimaal is, kost dat in de praktijk nauwelijks meer. Wij stellen dat in Haven dan ook standaard voor.',
      'Rond de jachthaven en het Havenhoofd zit horeca. Dat is werk met een eigen ritme: schoonmaak in de vroege ochtend voordat de zaak open gaat, en in het seizoen een hogere frequentie dan in de winter. Bij horeca ligt het accent op keuken, sanitair en de terrasstraat, en die laatste is bij een haven extra gevoelig voor aanslag door vocht en algen.',
      'De VvE-complexen in Haven zijn overwegend uit de jaren zeventig en tachtig. Dat betekent gemeenschappelijke trappenhuizen, galerijen en bergingsgangen, vaak zonder lift. Wij werken daar met een vaste dag en hangen een logboek in de hal, zodat bewoners meldingen kwijt kunnen zonder dat het bestuur als doorgeefluik moet fungeren. Voor besturen is dat in de praktijk de belangrijkste reden dat het rustiger wordt.',
      'Bedrijventerrein De Steiger, aan de rand van het stadsdeel, heeft grotere panden met een eigen ingang. Daar werken wij meestal in de avond. De combinatie werkt goed: de horeca en de VvE in de vroege ochtend, De Steiger in de avond, en daartussen de kantoren.',
    ],
    faq: [
      { q: 'Is twee keer per week niet duurder dan een keer?',
        a: 'Nauwelijks. De rondes zijn korter omdat het pand niet ver wegzakt, en in Almere Haven liggen de adressen zo dicht bij elkaar dat er geen reistijd tussen zit. Bij kleinere panden komt het vrijwel op hetzelfde uit.' },
      { q: 'Doen jullie ook horeca aan de haven?',
        a: 'Ja, in de vroege ochtend voordat de zaak opengaat. In het seizoen verhogen wij de frequentie, met extra aandacht voor het terras omdat aanslag door vocht en algen daar snel terugkomt.' },
      { q: 'Werken jullie voor VvE-complexen zonder lift?',
        a: 'Ja. Dat is in Almere Haven eerder regel dan uitzondering. Wij nemen het extra tijdsbeslag daarvan mee in de offerte, zodat er achteraf geen discussie over ontstaat.' },
    ],
  },

  'almere-poort': {
    h1: 'Schoonmaakbedrijf Almere Poort',
    title: 'Schoonmaakbedrijf Almere Poort, Duin en Europakwartier | Spotlezz',
    description: 'Schoonmaak in Almere Poort voor nieuwbouwkantoren, scholen, kinderopvang en VvE in Duin, Europakwartier en Homeruskwartier.',
    intro: 'Almere Poort is het nieuwste stadsdeel en groeit nog steeds. Dat betekent veel nieuwbouw, veel oplevering en veel jonge voorzieningen zoals scholen en kinderopvang.',
    answer:
      'In Almere Poort werkt Spotlezz voor nieuwbouwkantoren, scholen, kinderopvang en VvE-complexen in Duin, Europakwartier, Homeruskwartier en Olympiakwartier. Doordat hier veel wordt opgeleverd, verzorgen wij in Poort relatief vaak de opleveringsschoonmaak en de eerste vloerbehandeling.',
    facts: [
      { value: 'Nieuwbouw', label: 'Overwegend' },
      { value: '< 12 uur', label: 'Reactietijd' },
      { value: 'Oplevering', label: 'Veel gevraagd' },
      { value: '87', label: 'Beoordelingen' },
    ],
    topServices: ['opleveringsschoonmaak', 'kinderopvang-schoonmaak', 'vve-schoonmaak'],
    caseSlug: 'kobelco',
    review: 'Sinds Spotlezz bij ons in Almere schoonmaakt is het eindelijk consequent schoon. Ze reageren snel en de vaste schoonmaakster is een verademing vergeleken met ons vorige bureau.',
    reviewer: { name: 'Martijn van den Berg', role: 'Office Manager', city: 'Almere Poort', initial: 'M' },
    team: {
      name: 'Stefan Bakker',
      role: 'Voorman opleveringen',
      quote: 'In Poort staan we vaak in een pand waar de bouwer net weg is. Dan is de vraag niet hoe schoon het moet, maar wanneer de sleutel overgaat. Daar plan je alles omheen.',
    },
    areaHeading: 'Wat wij doen in Almere Poort',
    area: [
      'Almere Poort is het jongste stadsdeel van de stad en nog altijd in ontwikkeling. Duin, Europakwartier, Homeruskwartier, Columbuskwartier en Olympiakwartier zijn de afgelopen vijftien jaar grotendeels uit de grond gekomen, en er wordt nog steeds gebouwd. Dat bepaalt wat voor werk wij hier doen.',
      'De meest gevraagde dienst in Poort is de opleveringsschoonmaak. Bij nieuwbouw komen wij nadat de laatste bouwpartij het pand uit is, in twee rondes: een grove ronde voor puin, gruis, folie en stickers, en een fijne ronde vlak voor de sleuteloverdracht voor het stof dat daarna nog neerdaalt. Dat tweede venster is bij nieuwbouw geen luxe. Bouwstof blijft dagen in de lucht hangen en een pand dat een dag na de bouw is schoongemaakt, ziet er bij de inspectie alweer stoffig uit.',
      'Bij nieuwe panden brengen wij standaard de eerste beschermlaag op de vloer aan. Een pvc- of linoleumvloer verlaat de fabriek zonder onderhoudslaag, en zolang die er niet op zit schuurt het zand direct op het materiaal zelf. Dit is het goedkoopste moment om dat te doen, omdat het pand leeg en volledig toegankelijk is. Wie deze stap overslaat, betaalt binnen twee jaar voor een herstelbeurt die nu niet nodig was.',
      'Daarnaast heeft Poort veel jonge voorzieningen: basisscholen, kinderopvang en sportaccommodaties, passend bij de bevolkingsopbouw van het stadsdeel. Voor scholen en opvang werken wij met gescheiden materiaal per ruimte en met middelen die veilig zijn voor kinderen, en houden wij de uitgevoerde handelingen bij voor de inspectie.',
      'De VvE-complexen in Poort zijn nieuw en vaak groot, met gemeenschappelijke entrees, liften, parkeerkelders en fietsenbergingen. Die parkeerkelders zijn een aandachtspunt dat in de oplevering vaak wordt vergeten: bouwstof en cementsluier blijven daar het langst zitten en zijn na verloop van tijd aanzienlijk moeilijker te verwijderen.',
    ],
    faq: [
      { q: 'Doen jullie ook opleveringsschoonmaak bij nieuwbouw in Poort?',
        a: 'Ja, dat is hier onze meest gevraagde dienst. Wij werken in twee rondes: een grove ronde nadat de laatste bouwpartij weg is, en een fijne ronde vlak voor de sleuteloverdracht.' },
      { q: 'Waarom een eerste vloerbehandeling bij een nieuwe vloer?',
        a: 'Een nieuwe pvc- of linoleumvloer heeft nog geen beschermlaag. Zonder die laag schuurt het zand direct op het materiaal. Bij oplevering is het pand leeg en toegankelijk, en dat is het goedkoopste moment om die laag aan te brengen.' },
      { q: 'Nemen jullie de parkeerkelder mee bij een VvE?',
        a: 'Ja, als daarom gevraagd wordt. Bij nieuwbouw is dat verstandig: bouwstof en cementsluier blijven daar het langst zitten en zijn later een stuk lastiger te verwijderen.' },
    ],
  },
};
