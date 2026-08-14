# Beeldvoorbereiding voor Spotlezz.
#
# 1. Snijdt de ingebakken tekst en gradient van de branchekaart-afbeeldingen.
#    De zes sr-bestanden van spotlezz.nl zijn geen schone foto's maar
#    voorgerenderde kaarten met opschrift, pijl-icoon, gradient en afgeronde
#    hoeken in de pixels. Buiten het branchegrid zijn ze daardoor onbruikbaar:
#    de Kobelco-case toonde "Showroom schoonmaak", de homepage-hero ook.
#
# 2. Zet de klantlogo's onder hun juiste naam neer. De bestandsnamen klopten
#    geen van alle: kobelco.png is het logo van Mitsubishi Heavy Industries,
#    floor.png is ARENAGYM, kersvers.png is Mitsubishi Logisnext Europe en
#    logisnext.png is Innovally.
#
# 3. Maakt een deelafbeelding van 1.91:1 voor og:image.
#
# De originelen blijven staan. In het branchegrid zijn de opschriften juist wel
# correct, dus die versies worden daar nog gebruikt.
#
# Draaien:  powershell -ExecutionPolicy Bypass -File build/prepare-images.ps1

Add-Type -AssemblyName System.Drawing

$root = [System.IO.Path]::GetFullPath((Join-Path $PSScriptRoot '..\spotlezz.vercel.app\images'))

$encoder = [System.Drawing.Imaging.ImageCodecInfo]::GetImageEncoders() |
  Where-Object { $_.MimeType -eq 'image/jpeg' }
$params = New-Object System.Drawing.Imaging.EncoderParameters 1
$params.Param[0] = New-Object System.Drawing.Imaging.EncoderParameter(
  [System.Drawing.Imaging.Encoder]::Quality, 88L)

function Snijd($bronPad, $doelPad, $x, $y, $b, $h) {
  $bron = [System.Drawing.Image]::FromFile($bronPad)
  try {
    $doel = New-Object System.Drawing.Bitmap($b, $h)
    $g = [System.Drawing.Graphics]::FromImage($doel)
    try {
      $g.InterpolationMode = [System.Drawing.Drawing2D.InterpolationMode]::HighQualityBicubic
      $g.PixelOffsetMode  = [System.Drawing.Drawing2D.PixelOffsetMode]::HighQuality
      $g.DrawImage($bron,
        (New-Object System.Drawing.Rectangle(0, 0, $b, $h)),
        (New-Object System.Drawing.Rectangle($x, $y, $b, $h)),
        [System.Drawing.GraphicsUnit]::Pixel)
    } finally { $g.Dispose() }
    $doel.Save($doelPad, $encoder, $params)
    $doel.Dispose()
  } finally { $bron.Dispose() }
}

# --- 1. Opschriften wegsnijden -------------------------------------------

# De tekst begint rond 78% van de hoogte en de gradient rond 66%, dus 0.64
# haalt beide weg zonder in het onderwerp te snijden. De inzet haalt de
# afgeronde hoeken en de witte rand weg.
$keep  = 0.64
$inzet = 14

Write-Output 'Opschriften wegsnijden:'
foreach ($naam in @('branche-kantoor.jpg','branche-vve.jpg','case-kuchentreff.jpg',
                    'case-arena-gym.jpg','case-kobelco.jpg','pand-interieur.jpg',
                    'team-aan-het-werk.jpg')) {
  $pad = Join-Path $root $naam
  if (-not (Test-Path $pad)) { Write-Output "  ontbreekt: $naam"; continue }
  $img = [System.Drawing.Image]::FromFile($pad)
  $w = $img.Width; $hh = $img.Height; $img.Dispose()

  $b = $w - (2 * $inzet)
  $h = [int][math]::Floor($hh * $keep) - $inzet
  $uit = Join-Path $root ($naam -replace '\.jpg$', '-schoon.jpg')
  Snijd $pad $uit $inzet $inzet $b $h
  Write-Output ("  {0,-26} -> {1,-32} {2}x{3}  {4} KB" -f $naam,
    [System.IO.Path]::GetFileName($uit), $b, $h, [math]::Round((Get-Item $uit).Length/1KB))
}

# --- 2. Klantlogo's onder de juiste naam ---------------------------------

Write-Output ''
Write-Output "Klantlogo's hernoemen:"
$logos = @{
  'logisnext.png'   = 'klant-innovally.png'
  'kobelco.png'     = 'klant-mitsubishi-heavy-industries.png'
  'floor.png'       = 'klant-arenagym.png'
  'kersvers.png'    = 'klant-mitsubishi-logisnext.png'
  'klantlogo-1.png' = 'klant-wilmar-afbouw.png'
  'klantlogo-2.png' = 'klant-alliance.png'
  'klantlogo-3.png' = 'klant-innovally.png'
}
foreach ($bron in $logos.Keys | Sort-Object) {
  $van = Join-Path $root $bron
  $naar = Join-Path $root $logos[$bron]
  if (-not (Test-Path $van)) { continue }
  Copy-Item $van $naar -Force
  Write-Output ("  {0,-20} -> {1}" -f $bron, $logos[$bron])
}

# --- 3. Deelafbeelding voor og:image -------------------------------------

Write-Output ''
Write-Output 'Deelafbeelding:'
$ogBron = Join-Path $root 'professionele-schoonmaak.jpg'
if (Test-Path $ogBron) {
  $img = [System.Drawing.Image]::FromFile($ogBron)
  $w = $img.Width; $hh = $img.Height; $img.Dispose()
  # 1.91:1 uit het midden, de standaardverhouding voor Open Graph
  $h = [int][math]::Round($w / 1.91)
  if ($h -gt $hh) { $h = $hh }
  $y = [int][math]::Floor(($hh - $h) / 2)
  $uit = Join-Path $root 'og-deelafbeelding.jpg'
  Snijd $ogBron $uit 0 $y $w $h
  Write-Output ("  og-deelafbeelding.jpg  {0}x{1}  {2} KB" -f $w, $h,
    [math]::Round((Get-Item $uit).Length/1KB))
}
