/**
 * FAQ-laag. De hub draagt de volledige vragenset gegroepeerd per thema.
 * Losse pagina's tonen hooguit vijf vragen en linken door naar de hub.
 * Vragen met eigen zoekvolume krijgen een detailpagina; de rest blijft accordion.
 */

export const FAQ_THEMES = [
  {
    slug: 'kosten',
    label: 'Kosten en offerte',
    items: [
      {
        q: 'Wat kost een schoonmaakbedrijf per uur?',
        detail: 'wat-bepaalt-de-prijs-van-schoonmaak',
        a: 'Een uurtarief zegt weinig zolang niemand het pand heeft gezien. De prijs wordt bepaald door zes factoren: oppervlakte, frequentie, type ruimte, bezettingsgraad, tijdstip en extra werkzaamheden. Wij rekenen die factoren door in een offerte op maat en leggen per regel uit waar het bedrag vandaan komt.',
      },
      {
        q: 'Waar is een offerte van Spotlezz uit opgebouwd?',
        a: 'Uit het aantal vierkante meters per ruimtetype, de frequentie per week, het tijdstip waarop wij komen en de eventuele extra werkzaamheden zoals glasbewassing of vloeronderhoud. U ziet die regels los van elkaar terug, zodat u kunt schuiven met frequentie of scope zonder opnieuw te hoeven bellen.',
      },
      {
        q: 'Zitten de schoonmaakmiddelen en het materiaal bij de prijs in?',
        a: 'Ja. Machines, materiaal en onze ecologische schoonmaakmiddelen zitten in het tarief. Verbruiksartikelen voor uw eigen gebruik, zoals toiletpapier, handdoekrollen en zeep, staan als aparte regel op de offerte zodat u zelf kiest of u die bij ons afneemt.',
      },
      {
        q: 'Zit ik ergens aan vast?',
        a: 'Wij werken met een opzegtermijn van een maand. Geen jaarcontract met automatische verlenging waar u niet meer uitkomt. Dat 94 procent van onze klanten verlengt, willen wij verdienen met het werk en niet met de kleine lettertjes.',
      },
    ],
  },
  {
    slug: 'werkwijze',
    label: 'Werkwijze',
    items: [
      {
        q: 'Hoe vaak moet een kantoor schoongemaakt worden?',
        detail: 'hoe-vaak-moet-een-kantoor-schoongemaakt-worden',
        a: 'Voor de meeste kantoren is twee tot drie keer per week het omslagpunt. Sanitair en pantry zijn dan altijd op orde, terwijl u niet betaalt voor dagelijkse rondes op werkplekken die maar half bezet zijn. Bij meer dan dertig medewerkers of veel bezoek per dag is vijf keer per week doorgaans goedkoper dan periodiek herstelwerk.',
      },
      {
        q: 'Wat doet een schoonmaker tijdens een ronde?',
        a: 'Die volgt het werkprogramma dat wij samen met u hebben vastgelegd, per ruimte en per handeling. Werkplekken, sanitair, pantry, contactvlakken, vloeren en afval staan er standaard in. Wat er extra bij hoort, zoals beeldschermen of planten, spreken wij vooraf af en staat in het logboek.',
      },
      {
        q: 'Kan de schoonmaak buiten werktijd of in het weekend?',
        a: 'Ja. Wij werken in de ochtend voor kantoortijd, in de avond en in het weekend. Voor showrooms en sportscholen plannen wij standaard buiten openingstijd. U krijgt een vaste dag en een vast tijdvak, zodat u weet wanneer er iemand in het pand is.',
      },
      {
        q: 'Wat is het verschil tussen dagschoonmaak en avondschoonmaak?',
        a: 'Bij dagschoonmaak ziet u de schoonmaker en kunt u direct iets doorgeven, wat de lijnen kort houdt. Avondschoonmaak voorkomt geluid en loop tijdens werktijd en is praktischer bij open kantoortuinen. Veel klanten combineren: sanitair en pantry overdag, de rest in de avond.',
      },
      {
        q: 'Hoe snel kan een klant starten?',
        a: 'Na akkoord starten wij vaak binnen 24 tot 48 uur, afhankelijk van de beschikbaarheid van teams in uw regio. Bij grotere panden plannen wij eerst een startdag in waarop wij het pand op niveau brengen, daarna gaat het reguliere programma in.',
      },
      {
        q: 'Hoe ziet het starttraject eruit?',
        a: 'Wij bezoeken uw pand, leggen het werkprogramma vast, stellen uw vaste team samen en introduceren dat team aan u. In de eerste maand controleren wij wekelijks en stellen bij waar nodig. Daarna evalueren wij vier keer per jaar.',
      },
    ],
  },
  {
    slug: 'kwaliteit',
    label: 'Kwaliteit en team',
    items: [
      {
        q: 'Hoe borgen jullie de kwaliteit?',
        a: 'Met wekelijkse controles op basis van de Spotlezz-checklist die op uw pand is afgestemd, een logboek in het pand en vier evaluatiegesprekken per jaar. U heeft daarnaast een vast aanspreekpunt, zodat een melding niet in een algemene inbox blijft liggen.',
      },
      {
        q: 'Werken jullie met een vast team?',
        a: 'Ja. Elk pand krijgt een vast team en een vaste eerste schoonmaker. Bij ziekte of vakantie valt iemand in die het pand kent en met hetzelfde werkprogramma werkt. Wisselende gezichten zijn de belangrijkste reden dat schoonmaak misgaat, dus daar sturen wij bewust op.',
      },
      {
        q: 'Zijn jullie medewerkers gescreend en opgeleid?',
        a: 'Ons team is intern opgeleid volgens onze eigen werkprogramma\'s en beschikt over de benodigde certificaten. Medewerkers werken in herkenbare bedrijfskleding van Spotlezz, zodat in uw pand altijd duidelijk is wie er rondloopt.',
      },
      {
        q: 'Wat als ik niet tevreden ben over een ronde?',
        a: 'Meld het bij uw vaste aanspreekpunt. Wij komen het herstellen zonder extra kosten en noteren de melding in het logboek, zodat wij zien of het eenmalig is of dat er iets in het werkprogramma moet veranderen.',
      },
      {
        q: 'Heb ik een vast contactpersoon?',
        a: 'Ja, u heeft een vast aanspreekpunt voor planning, kwaliteit en facturatie. Bij calamiteiten zijn wij ook buiten kantooruren bereikbaar.',
      },
    ],
  },
  {
    slug: 'duurzaamheid',
    label: 'Duurzaamheid',
    items: [
      {
        q: 'Zijn de producten veilig voor mijn team?',
        a: 'Wij werken met ecologische, biologisch afbreekbare middelen zonder agressieve chemicaliën. Dat is prettiger voor het binnenklimaat en noodzakelijk op plekken als kinderopvang en horeca. Op verzoek leveren wij de productbladen aan voor uw RI&E.',
      },
      {
        q: 'Kunnen jullie schoonmaken zonder chemische middelen?',
        a: 'Voor veel handelingen wel. Met microvezel en gedemineraliseerd water bereiken wij op de meeste oppervlakken hetzelfde resultaat. Voor sanitair en desinfectie van contactvlakken blijft een toegelaten middel nodig, en daar kiezen wij de mildste variant die het werk doet.',
      },
      {
        q: 'Wat doen jullie aan afval en verpakkingen?',
        a: 'Wij werken met navulverpakkingen en concentraten in plaats van steeds nieuwe flessen, en scheiden afval volgens de indeling die in uw pand aanwezig is. Waar die indeling ontbreekt, adviseren wij bij het opzetten ervan.',
      },
    ],
  },
  {
    slug: 'kiezen',
    label: 'Een schoonmaakbedrijf kiezen',
    items: [
      {
        q: 'Welke vragen moet ik stellen aan een schoonmaakbedrijf?',
        detail: 'hoe-kies-je-een-schoonmaakbedrijf',
        a: 'Vraag naar het werkprogramma per ruimte, wie er daadwerkelijk komt en of dat elke week dezelfde persoon is, hoe kwaliteit wordt gecontroleerd en vastgelegd, wat de opzegtermijn is, en of materiaal en middelen in het tarief zitten. Een partij die op die vijf vragen concreet antwoordt, verrast u later niet.',
      },
      {
        q: 'Werken jullie ook voor particulieren?',
        a: 'Nee, wij werken uitsluitend zakelijk. Kantoren, hotels, showrooms, sportscholen, kinderopvang en VvE. Daardoor kunnen wij met vaste teams en vaste werkprogramma\'s werken in plaats van met losse afspraken.',
      },
      {
        q: 'In welke plaatsen zijn jullie actief?',
        a: 'Almere en de wijken Stad, Buiten, Haven en Poort, plus Lelystad, Amsterdam en Amersfoort. Op elke locatiepagina staat welke teams daar rijden en hoe snel wij er kunnen zijn.',
      },
    ],
  },
  {
    slug: 'service',
    label: 'Service en aanvullende diensten',
    items: [
      {
        q: 'Bieden jullie ook sanitaire artikelen aan?',
        a: 'Ja. Via onze hygiëneservice houden wij dispensers, toiletpapier, handdoekrollen en zeep op voorraad en vullen wij tijdens de reguliere ronde bij. U krijgt daar een aparte regel voor op de factuur en geen losse bestellingen meer.',
      },
      {
        q: 'Doen jullie ook glasbewassing en vloeronderhoud?',
        a: 'Ja, beide als losse dienst of als periodiek onderdeel van uw contract. Glasbewassing draait doorgaans in een cyclus van vier tot acht weken, vloeronderhoud een tot vier keer per jaar afhankelijk van de vloer en de belasting.',
      },
      {
        q: 'Zijn jullie bereikbaar bij calamiteiten?',
        a: 'Ja. Bij lekkage, glasschade of een andere calamiteit zijn wij ook buiten kantooruren bereikbaar en komen wij zo snel mogelijk langs. Voor bestaande klanten geldt daarbij voorrang op de reguliere planning.',
      },
      {
        q: 'Hoe houden jullie mij op de hoogte?',
        a: 'Via het logboek in het pand, korte lijnen met uw vaste aanspreekpunt en vier evaluaties per jaar waarin wij de controles en meldingen met u doorlopen.',
      },
    ],
  },
];

/** Platte lijst van alle vragen. */
export const ALL_FAQ = FAQ_THEMES.flatMap((t) =>
  t.items.map((i) => ({ ...i, theme: t.label, themeSlug: t.slug })));

/** De vijf vragen die op de homepage staan. */
export const HOME_FAQ = [
  ALL_FAQ.find((q) => q.q === 'Wat kost een schoonmaakbedrijf per uur?'),
  ALL_FAQ.find((q) => q.q === 'Hoe vaak moet een kantoor schoongemaakt worden?'),
  ALL_FAQ.find((q) => q.q === 'Kan de schoonmaak buiten werktijd of in het weekend?'),
  ALL_FAQ.find((q) => q.q === 'Hoe borgen jullie de kwaliteit?'),
  ALL_FAQ.find((q) => q.q === 'Zijn de producten veilig voor mijn team?'),
];

/** Vijf vragen per branchepagina. */
export function faqForService(slug) {
  const gemeenschappelijk = [
    ALL_FAQ.find((q) => q.q === 'Wat kost een schoonmaakbedrijf per uur?'),
    ALL_FAQ.find((q) => q.q === 'Hoe snel kan een klant starten?'),
    ALL_FAQ.find((q) => q.q === 'Werken jullie met een vast team?'),
    ALL_FAQ.find((q) => q.q === 'Kan de schoonmaak buiten werktijd of in het weekend?'),
    ALL_FAQ.find((q) => q.q === 'Zijn de producten veilig voor mijn team?'),
  ];
  return SERVICE_FAQ[slug] ? [...SERVICE_FAQ[slug], ...gemeenschappelijk].slice(0, 5) : gemeenschappelijk;
}

/** Een of twee vragen die echt bij die dienst horen, bovenaan de vijf. */
export const SERVICE_FAQ = {
  'kantoor-schoonmaak': [{
    q: 'Maken jullie ook de werkplekken en beeldschermen schoon?',
    a: 'Ja, mits dat in het werkprogramma staat. Bureaus en contactvlakken doen wij standaard. Beeldschermen en toetsenborden nemen wij op verzoek mee, meestal een vaste dag per week, omdat medewerkers hun bureau dan leeg opleveren.',
  }],
  'hotel-schoonmaak': [{
    q: 'Kunnen jullie werken rond check-in en check-out?',
    a: 'Ja. Wij plannen de kamerschoonmaak tussen check-out en check-in en de publieke ruimtes in de rustige uren. Bij een hoge bezetting schalen wij het team op die dag op in plaats van de rondes te verkorten.',
  }],
  'showroom-schoonmaak': [{
    q: 'Hoe houden jullie glas en hoogglans streeploos?',
    a: 'Met gedemineraliseerd water en microvezel, en door de showroom voor openingstijd te doen zodat niets nadroogt onder de spots. Grote glaspartijen nemen wij mee in een vaste glasbewassingscyclus.',
  }],
  'fitnesscentrum-schoonmaak': [{
    q: 'Hoe voorkomen jullie schimmel in de doucheruimtes?',
    a: 'Dagelijkse reiniging van vloer en wanden tot op tegelhoogte, periodiek een zure reiniging tegen kalkaanslag en controle op de ventilatie. Kalk is waar schimmel zich aan hecht, dus dat is het echte aangrijpingspunt.',
  }],
  'kinderopvang-schoonmaak': [{
    q: 'Werken jullie volgens het hygiëneprotocol van de GGD?',
    a: 'Ja. Wij werken met kindveilige middelen, gescheiden materiaal per ruimte om kruisbesmetting te voorkomen, en leggen de uitgevoerde handelingen vast zodat u dat bij een inspectie kunt laten zien.',
  }],
  'vve-schoonmaak': [{
    q: 'Wie is bij een VvE het aanspreekpunt?',
    a: 'Een bestuurslid of de beheerder, en bij ons een vaste contactpersoon. Wij hangen een logboek in de hal waarin bewoners meldingen kwijt kunnen, zodat het bestuur niet de tussenpersoon hoeft te zijn.',
  }],
  glasbewassing: [{
    q: 'Hoe vaak moeten de ramen gezonnen worden?',
    a: 'Voor een kantoor aan een doorgaande weg werkt een cyclus van vier weken, op een rustiger bedrijventerrein volstaat acht weken. Showrooms doen wij meestal elke twee weken omdat glas daar onderdeel van de presentatie is.',
  }],
  vloeronderhoud: [{
    q: 'Hoe vaak heeft een pvc-vloer een onderhoudsbeurt nodig?',
    a: 'Bij normale kantoorbelasting een tot twee keer per jaar dieptereiniging met een nieuwe beschermlaag. In entrees en gangen met veel loop is drie tot vier keer realistischer, omdat de laag daar het snelst wegloopt.',
  }],
  opleveringsschoonmaak: [{
    q: 'Op welk moment kunnen jullie komen?',
    a: 'Zodra de laatste bouwpartij het pand uit is. Wij plannen liefst twee dagvensters: een grove ronde direct na de bouw en een fijne ronde vlak voor sleuteloverdracht, zodat het stof dat na de eerste ronde nog neerdaalt ook weg is.',
  }],
  hygieneservice: [{
    q: 'Kan ik mijn eigen dispensers houden?',
    a: 'Ja, als daar navullingen voor te krijgen zijn. Waar dispensers verouderd of lastig te vullen zijn, stellen wij vervanging voor in bruikleen, zodat u niet in een duur navulsysteem vastzit.',
  }],
};

/* ------------------------------------------------------------------ */
/* Detailpagina's: alleen voor vragen met aantoonbaar zoekvolume        */
/* ------------------------------------------------------------------ */

export const FAQ_DETAILS = [
  {
    slug: 'wat-bepaalt-de-prijs-van-schoonmaak',
    theme: 'Kosten en offerte',
    themeSlug: 'kosten',
    h1: 'Wat bepaalt de prijs van een schoonmaakbedrijf?',
    title: 'Wat bepaalt de prijs van een schoonmaakbedrijf? | Spotlezz',
    description: 'De zes factoren die het bedrag op een schoonmaakofferte bepalen: oppervlakte, frequentie, type ruimte, bezetting, tijdstip en extra werk.',
    pillar: 'kantoor-schoonmaak',
    short: 'De prijs van schoonmaak wordt bepaald door zes factoren: het aantal vierkante meters, de frequentie per week, het type ruimte, de bezettingsgraad, het tijdstip waarop wij komen en de extra werkzaamheden zoals glasbewassing of vloeronderhoud. Een uurtarief zonder die context zegt niets over wat u uiteindelijk betaalt.',
    factors: [
      { title: 'Oppervlakte in vierkante meters',
        body: 'De basis van elke calculatie, maar niet het totaal aantal meters van het pand. Wat telt is de verdeling per ruimtetype. Een vierkante meter sanitair kost een veelvoud van een vierkante meter open kantoorvloer, omdat er meer handelingen op staan en de norm strenger is. Wij meten daarom per ruimtesoort en niet per verdieping.' },
      { title: 'Frequentie per week',
        body: 'Vaker komen is per bezoek goedkoper, omdat het pand nooit ver wegzakt en de ronde korter wordt. Eens per week is bijna nooit voordeliger dan drie keer per week: de eerste ronde na een lange periode kost extra tijd en dat betaalt u alsnog. Bij twee tot drie keer per week ligt voor de meeste kantoren het omslagpunt.' },
      { title: 'Type ruimte',
        body: 'Sanitair, pantry en kleedkamers zijn de duurste meters, gevolgd door entrees en vergaderruimtes. Open kantoorvloer en gangen zijn het goedkoopst. Een pand van 500 vierkante meter met acht toiletten kost meer dan een pand van 700 vierkante meter met twee, en dat verschil kunt u pas zien als de offerte per ruimtetype is opgebouwd.' },
      { title: 'Bezettingsgraad',
        body: 'Niet hoeveel bureaus er staan, maar hoeveel mensen er dagelijks zijn en hoeveel bezoek er binnenkomt. Sinds hybride werken zien wij panden waar op dinsdag en donderdag driemaal zoveel mensen zitten als op vrijdag. Daar is een gelijkmatig weekprogramma weggegooid geld, en stemmen wij de rondes af op de drukke dagen.' },
      { title: 'Tijdstip',
        body: 'Schoonmaak tijdens kantooruren is het voordeligst. Werk in de vroege ochtend, de avond of het weekend brengt een toeslag met zich mee. Daar staat tegenover dat u geen geluid en loop tijdens werktijd heeft, wat bij open kantoortuinen en showrooms zwaarder weegt dan het prijsverschil.' },
      { title: 'Extra werkzaamheden',
        body: 'Glasbewassing, vloeronderhoud, tapijtreiniging en het beheer van verbruiksartikelen staan los van de reguliere ronde. Wij zetten ze als aparte regel op de offerte, met hun eigen frequentie. Zo kunt u de glascyclus verlengen of het vloeronderhoud een kwartaal opschuiven zonder dat het hele contract open moet.' },
    ],
  },
  {
    slug: 'hoe-vaak-moet-een-kantoor-schoongemaakt-worden',
    theme: 'Werkwijze',
    themeSlug: 'werkwijze',
    h1: 'Hoe vaak moet een kantoor schoongemaakt worden?',
    title: 'Hoe vaak moet een kantoor schoongemaakt worden? | Spotlezz',
    description: 'Twee tot drie keer per week is voor de meeste kantoren het omslagpunt. Wanneer dagelijks nodig is en wanneer u geld weggooit.',
    pillar: 'kantoor-schoonmaak',
    short: 'Voor de meeste kantoren is twee tot drie keer per week het omslagpunt. Sanitair en pantry blijven dan op orde, terwijl u niet betaalt voor dagelijkse rondes op werkplekken die half bezet zijn. Vanaf ongeveer dertig medewerkers, of bij dagelijks bezoek van klanten, is vijf keer per week doorgaans goedkoper dan periodiek herstelwerk.',
    factors: [
      { title: 'Sanitair bepaalt de ondergrens',
        body: 'Alle andere ruimtes kunnen een dag overslaan; sanitair niet. Zodra meer dan vijftien mensen dagelijks van hetzelfde toilet gebruikmaken, is dagelijkse reiniging van sanitair de facto verplicht, ook als de rest van het pand twee keer per week aan de beurt is. Wij splitsen die frequenties daarom los in het werkprogramma.' },
      { title: 'Tel aanwezigen, geen bureaus',
        body: 'Hybride werken heeft de rekensom veranderd. Een kantoor met tachtig werkplekken waar dagelijks vijfentwintig mensen zitten, heeft het schoonmaakprofiel van een kantoor met dertig plekken. Kijk naar de aanwezigheidsregistratie of de badgedata van een gemiddelde maand, en stem daar de rondes op af.' },
      { title: 'Bezoek weegt zwaarder dan personeel',
        body: 'Een advocatenkantoor met twintig medewerkers en dagelijks cliënten over de vloer heeft een hogere frequentie nodig dan een softwarebedrijf met veertig mensen en nauwelijks bezoek. Entree, vergaderruimtes en het bezoekerstoilet bepalen de eerste indruk en verdienen daarom een eigen frequentie.' },
      { title: 'Waar dagelijks echt loont',
        body: 'Bij horeca in het pand, bij een kantine met warme lunch, bij meer dan dertig dagelijkse aanwezigen en bij showrooms of ontvangstruimtes die er altijd goed uit moeten zien. In die gevallen kost periodiek herstelwerk, zoals dieptereiniging van vloeren en het wegwerken van achterstand, meer dan de extra rondes.' },
      { title: 'Waar u geld weggooit',
        body: 'Dagelijks stofzuigen van een kantoorvloer die twee dagen per week bezet is. Dagelijks bureaus afnemen bij flexplekken die medewerkers zelf leeg opleveren. Wekelijks vloeronderhoud op een vloer die per kwartaal een beurt nodig heeft. Dat zijn de posten waar wij bij een intake meestal als eerste in kunnen snijden.' },
    ],
  },
  {
    slug: 'hoe-kies-je-een-schoonmaakbedrijf',
    theme: 'Een schoonmaakbedrijf kiezen',
    themeSlug: 'kiezen',
    h1: 'Hoe kies je een schoonmaakbedrijf?',
    title: 'Hoe kies je een schoonmaakbedrijf? Vijf vragen | Spotlezz',
    description: 'Vijf vragen die het verschil laten zien tussen schoonmaakbedrijven die op papier hetzelfde kosten. Werkprogramma, vaste mensen, controle, opzegtermijn en scope.',
    pillar: 'kantoor-schoonmaak',
    short: 'Vraag naar het werkprogramma per ruimte, naar wie er daadwerkelijk komt en of dat elke week dezelfde persoon is, naar hoe kwaliteit wordt gecontroleerd en vastgelegd, naar de opzegtermijn, en naar wat er wel en niet in het tarief zit. Een partij die op die vijf vragen concreet antwoordt, verrast u later niet.',
    factors: [
      { title: 'Vraag om het werkprogramma, niet om de offerte',
        body: 'Een offerte is een bedrag, een werkprogramma is een belofte. Vraag welke handelingen per ruimte worden uitgevoerd en met welke frequentie. Krijgt u een algemene omschrijving als volledige kantoorschoonmaak, dan is er niets waar u later op kunt terugvallen als iets structureel wordt overgeslagen.' },
      { title: 'Vraag wie er komt en hoe vaak dat wisselt',
        body: 'Dit is de vraag die het meeste voorspelt over het eerste jaar. Wisselend personeel betekent dat het werkprogramma elke week opnieuw moet worden uitgelegd en dat kleine afspraken verdwijnen. Vraag ook wat er bij ziekte gebeurt: valt er iemand in die het pand kent, of komt er een onbekende met een algemene instructie.' },
      { title: 'Vraag hoe kwaliteit wordt vastgelegd',
        body: 'Iedereen zegt controles uit te voeren. De vraag is of u de uitkomst ziet. Vraag naar de frequentie, naar wie controleert, en of u de bevindingen krijgt. Zonder vastlegging is een klacht altijd een welles-nietesgesprek en heeft u geen basis om iets af te dwingen.' },
      { title: 'Vraag naar de opzegtermijn',
        body: 'Een partij die zeker is van het werk heeft geen jaarcontract met stilzwijgende verlenging nodig. Een korte opzegtermijn is het duidelijkste signaal dat een schoonmaakbedrijf erop rekent u op kwaliteit te houden. Let ook op indexatie: vraag vooraf hoe en wanneer die wordt toegepast.' },
      { title: 'Vraag wat er niet in zit',
        body: 'Het verschil tussen twee offertes zit meestal in wat er buiten valt. Glasbewassing, vloeronderhoud, verbruiksartikelen, de periodieke dieptereiniging en het werk in de vakantieperiode. Leg beide offertes naast elkaar op scope voordat u ze op prijs vergelijkt, anders vergelijkt u twee verschillende dingen.' },
    ],
  },
];
