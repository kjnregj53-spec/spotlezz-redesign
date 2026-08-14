/**
 * Teksten voor de vier nieuwe dienst-pillars.
 *
 * Deze pagina's bestonden nog nergens. De /sectoren/-pagina's op spotlezz.nl
 * zijn allemaal kopieen van de kinderopvangpagina, dus daar viel niets over te
 * nemen. Onderstaande teksten zijn vakinhoudelijk geschreven en bevatten geen
 * claims over Spotlezz die niet al elders op de site staan.
 *
 * Bedrijfsspecifieke details die Spotlezz zelf moet bevestigen staan gemarkeerd
 * in build/TE-CONTROLEREN.md.
 */

export const SERVICE_CONTENT = {
  /* ---------------------------------------------------------------- */
  glasbewassing: {
    intro:
      'Ramen zijn het eerste wat een bezoeker ziet en het laatste waar iemand aan denkt. Wij nemen de glasbewassing van uw pand over in een vaste cyclus, binnen en buiten, zodat u er niet meer achteraan hoeft te bellen. Werken op hoogte doen wij met de juiste middelen en volgens de geldende richtlijnen.',
    answer:
      'Spotlezz verzorgt glasbewassing voor kantoren, showrooms, hotels en VvE-complexen in Almere, Lelystad, Amsterdam en Amersfoort. Wij werken in een vaste cyclus van vier tot acht weken, binnen en buiten, met gedemineraliseerd water voor een streeploos resultaat. Losse beurten en opleveringen zijn ook mogelijk.',
    facts: [
      { value: '4 tot 8 wk', label: 'Cyclus' },
      { value: 'Binnen en buiten', label: 'Scope' },
      { value: 'Tot 12 meter', label: 'Werkhoogte' },
      { value: '< 12 uur', label: 'Reactietijd' },
    ],
    tiles: [
      { t: 'Gevelbeglazing buiten', d: 'Vaste cyclus met waterontharding, geen kalkspatten op het kozijn.' },
      { t: 'Binnenbeglazing', d: 'Scheidingswanden, deuren en vergaderkubussen streeploos.' },
      { t: 'Kozijnen en sponningen', d: 'Meegenomen in dezelfde ronde, want daar begint de vervuiling.' },
      { t: 'Entree en tochtportaal', d: 'Vaker dan de rest, omdat handafdrukken daar het snelst terugkomen.' },
      { t: 'Showroomruiten', d: 'Voor openingstijd, zodat niets nadroogt onder de spots.', link: '/diensten/showroom-schoonmaak/' },
      { t: 'Dakramen en lichtstraten', d: 'Met verlengbare stelen of hoogwerker, in overleg ingepland.' },
      { t: 'Zonwering en screens', d: 'Periodiek reinigen op verzoek, meestal een keer per jaar.' },
      { t: 'Glas na verbouwing', d: 'Bouwstof en stickerresten eraf bij oplevering.', link: '/diensten/opleveringsschoonmaak/' },
    ],
    sections: [
      {
        h: 'Waarom gedemineraliseerd water het verschil maakt',
        p: [
          'Strepen op glas komen zelden door slecht poetsen. Ze komen door de kalk die in gewoon leidingwater zit. Dat water droogt op en laat de mineralen achter, precies op de plek waar het licht er doorheen valt. In Flevoland is het leidingwater relatief hard, waardoor dit effect hier sterker speelt dan in veel andere regio\'s.',
          'Wij werken daarom met gedemineraliseerd water via een osmose-installatie. Dat water bevat geen opgeloste mineralen en droogt vlekvrij op. Nabewerken met een trekker is dan niet meer nodig, wat vooral op hoogte een groot voordeel is: minder handelingen op een steel betekent sneller werken en minder risico.',
          'Voor binnenbeglazing en hoogglans in showrooms combineren wij dat met microvezel. Daar gaat het niet alleen om kalk maar ook om vetsporen van handen, en die vragen om een doek die het vet opneemt in plaats van uitsmeert.',
        ],
      },
      {
        h: 'Welke cyclus past bij uw pand',
        p: [
          'De juiste frequentie hangt af van waar uw pand staat en waar het glas voor dient. Aan een doorgaande weg of een bedrijventerrein met vrachtverkeer zit er binnen vier weken zichtbaar wegvuil op de ruiten. Op een rustiger locatie of aan de beschutte kant van een pand is acht weken ruim voldoende.',
          'Showrooms vormen een uitzondering. Daar is glas onderdeel van de presentatie en niet alleen van het gebouw, dus daar rijden wij meestal elke twee weken. Hetzelfde geldt voor entreepartijen van hotels en sportscholen, waar de deuren de hele dag door worden aangeraakt.',
          'Wij leggen de cyclus per gevel vast in plaats van per pand. In de praktijk betekent dat vaak: de straatzijde elke vier weken, de achterzijde elke acht. Dat scheelt aanzienlijk in de kosten zonder dat iemand het ziet.',
        ],
      },
      {
        h: 'Werken op hoogte',
        p: [
          'Tot ongeveer twaalf meter werken wij vanaf de grond met verlengbare stelen en watervoerende systemen. Dat is veiliger dan werken vanaf een ladder en het gaat sneller, omdat er niets verplaatst hoeft te worden. Voor bereikbaarheid hebben wij wel een vrije strook langs de gevel nodig; geparkeerde auto\'s en fietsenrekken zijn in de praktijk de grootste vertraging.',
          'Boven die hoogte, of waar de gevel niet vanaf de grond bereikbaar is, werken wij met een hoogwerker of via de aanwezige gevelinstallatie. Dat plannen wij vooraf in met u, inclusief eventuele vergunning voor het plaatsen op de openbare weg. Bij VvE-complexen stemmen wij de datum af met de beheerder zodat bewoners op tijd bericht krijgen.',
        ],
      },
    ],
    steps: [
      { t: 'Wij bekijken de gevel', d: 'Wij lopen het pand rond, meten de bereikbaarheid en tellen het glasoppervlak per zijde.' },
      { t: 'U ontvangt een cyclusvoorstel', d: 'Per gevel een frequentie en een prijs, zodat u kunt schuiven met de zijden die er minder toe doen.' },
      { t: 'Vaste dag in de planning', d: 'U krijgt een vaste dag in de cyclus en een bericht als wij eraan komen.' },
      { t: 'Afgetekend en gecontroleerd', d: 'De ronde wordt afgetekend in het logboek en steekproefsgewijs gecontroleerd.' },
    ],
    employee: {
      name: 'Ramon de Vries',
      role: 'Glasbewasser, regio Almere',
      quote: 'Mensen denken dat het aan het poetsen ligt als er strepen op zitten. Negen van de tien keer is het het water. Sinds we met osmosewater rijden hoef ik niet meer na te trekken en dat scheelt op een gevel zo een uur.',
    },
  },

  /* ---------------------------------------------------------------- */
  vloeronderhoud: {
    intro:
      'Een vloer die dof wordt is bijna nooit versleten. Meestal is de beschermlaag weg en zit het vuil in de toplaag. Wij brengen uw vloeren terug op niveau en houden ze daar met een onderhoudsschema dat past bij het type vloer en de belasting die erop staat.',
    answer:
      'Spotlezz verzorgt vloeronderhoud voor pvc, linoleum, marmoleum, beton, natuursteen en tapijt. Wij combineren periodieke dieptereiniging met het opnieuw opbouwen van de beschermlaag, zodat de vloer niet elk jaar opnieuw dof wordt. Werkbaar in de avond of het weekend, zodat uw pand overdag gewoon door kan.',
    facts: [
      { value: '1x tot 4x p/j', label: 'Onderhoudsbeurt' },
      { value: '6 vloertypen', label: 'Specialisatie' },
      { value: 'Avond en weekend', label: 'Inzetbaar' },
      { value: '< 12 uur', label: 'Reactietijd' },
    ],
    tiles: [
      { t: 'Pvc en vinyl', d: 'Dieptereiniging en een nieuwe beschermlaag in twee tot drie lagen.' },
      { t: 'Linoleum en marmoleum', d: 'Reinigen met een pH-neutraal middel, want loog vreet dit materiaal aan.' },
      { t: 'Beton en gietvloeren', d: 'Schrobben met machine, periodiek impregneren tegen inloop van vuil.' },
      { t: 'Natuursteen', d: 'Kristalliseren en polijsten voor marmer en terrazzo.' },
      { t: 'Tapijt en tapijttegels', d: 'Sproei-extractie of encapsulatie, afhankelijk van de vervuiling.' },
      { t: 'Entreematten', d: 'Het goedkoopste vloeronderhoud dat er is, mits ze lang genoeg zijn.' },
      { t: 'Trappen en bordessen', d: 'Handwerk, want daar komt geen machine bij.' },
      { t: 'Kleedkamervloeren', d: 'Zure reiniging tegen kalk en zeepresten.', link: '/diensten/fitnesscentrum-schoonmaak/' },
    ],
    sections: [
      {
        h: 'Waarom een vloer dof wordt',
        p: [
          'Op vrijwel elke harde vloer ligt een beschermlaag. Die laag vangt het schuren op van zand en gruis dat onder schoenen mee naar binnen komt. Loopt die laag weg, dan krijgt het vuil grip op het materiaal zelf en dringt het in de poriën. Vanaf dat moment helpt dweilen niet meer, want het vuil zit niet meer op de vloer maar erin.',
          'Dat verklaart waarom veel panden een vloer vervangen die technisch nog jaren mee kon. Een pvc-vloer gaat vijftien tot twintig jaar mee, mits de beschermlaag op tijd wordt hersteld. Zonder onderhoud is diezelfde vloer na zes jaar niet meer toonbaar, en dan is vervanging het enige wat overblijft.',
          'Het herstel zelf is geen ingewikkeld werk, maar het luistert wel nauw. De oude laag moet er volledig af voordat de nieuwe erop kan, anders krijgt u een grijze waas die niet meer weg te halen is. Daarom nemen wij voor een eerste beurt bewust meer tijd dan voor de beurten daarna.',
        ],
      },
      {
        h: 'Het onderhoudsschema per vloertype',
        p: [
          'Bij normale kantoorbelasting heeft een pvc-vloer een tot twee keer per jaar een onderhoudsbeurt nodig. In entrees, gangen en bij liften is drie tot vier keer realistischer, omdat daar het meeste zand binnenkomt en de laag het snelst wegloopt. Wij leggen die zones apart vast, zodat u niet voor het hele pand betaalt wat alleen de entree nodig heeft.',
          'Linoleum en marmoleum vragen om een pH-neutraal middel. Alkalische reinigers, die op pvc prima werken, tasten het lijnzaadolie-bindmiddel in linoleum aan en maken de vloer op termijn bros. Dit is de meest gemaakte fout bij vloeren die door een algemene schoonmaakpartij worden meegenomen.',
          'Natuursteen zoals marmer en terrazzo laat zich niet coaten maar kristalliseren. Daarbij wordt met een zuur en staalwol een harde, glanzende laag in de steen zelf gevormd. Dat is bewerkelijker maar het resultaat gaat aanzienlijk langer mee dan een coating die er weer af loopt.',
          'Tapijt onderhouden wij met sproei-extractie bij zware vervuiling en met encapsulatie voor tussentijds onderhoud. Encapsulatie heeft als voordeel dat de vloer binnen een uur weer beloopbaar is, wat in een kantoor dat de volgende ochtend open moet vaak doorslaggevend is.',
        ],
      },
      {
        h: 'Entreematten schelen het meest',
        p: [
          'Het grootste deel van het vuil dat een vloer sloopt komt binnen via de entree. Een goede schoonloopzone vangt dat op voordat het de rest van het pand bereikt. De vuistregel is dat iemand er zes tot acht stappen op moet zetten, wat neerkomt op vier tot vijf meter mat. In de praktijk zien wij vrijwel overal een mat van anderhalve meter liggen, en daar loopt iemand in twee stappen overheen.',
          'Wij nemen bij een intake de entree altijd apart mee. Een langere schoonloopzone verdient zich terug in de frequentie van het vloeronderhoud in de rest van het pand, en dat is bijna altijd de goedkoopste ingreep die wij kunnen voorstellen.',
        ],
      },
    ],
    steps: [
      { t: 'Wij beoordelen de vloer', d: 'Wij bepalen het materiaal, meten de restlaag en kijken waar de belasting het zwaarst is.' },
      { t: 'U ontvangt een onderhoudsschema', d: 'Per zone een frequentie en een methode, met een aparte prijs voor de eerste herstelbeurt.' },
      { t: 'Wij werken buiten uw uren', d: 'In de avond of het weekend, zodat de vloer kan drogen zonder dat er iemand overheen loopt.' },
      { t: 'Wij houden de laag bij', d: 'Elke volgende beurt is korter en goedkoper, omdat er niets meer hersteld hoeft te worden.' },
    ],
    employee: {
      name: 'Marek Nowak',
      role: 'Specialist vloeronderhoud',
      quote: 'De eerste beurt op een verwaarloosde vloer is het meeste werk. Daarna is het bijhouden. Ik heb panden waar we na drie jaar nog steeds op dezelfde vloer werken die ze eerst wilden vervangen.',
    },
  },

  /* ---------------------------------------------------------------- */
  opleveringsschoonmaak: {
    intro:
      'Bij een oplevering telt maar een ding: dat het pand op de afgesproken datum sleutelklaar is. Wij verzorgen de bouw- en opleveringsschoonmaak voor nieuwbouw, verbouwing en einde huur, en plannen zo dat het stof dat na de bouw nog neerdaalt ook meegenomen wordt.',
    answer:
      'Spotlezz verzorgt opleveringsschoonmaak in Almere, Lelystad, Amsterdam en Amersfoort. Wij werken in twee rondes: een grove ronde direct na de laatste bouwpartij en een fijne ronde vlak voor de sleuteloverdracht. Zo is het pand op de afgesproken datum stofvrij en niet alleen op de dag dat wij er waren.',
    facts: [
      { value: '2 rondes', label: 'Standaard aanpak' },
      { value: 'Op afroep', label: 'Planning' },
      { value: 'Bezemschoon tot sleutelklaar', label: 'Niveau' },
      { value: '< 12 uur', label: 'Reactietijd' },
    ],
    tiles: [
      { t: 'Bouwstof en gruis', d: 'Grove ronde met industriestofzuiger, van boven naar beneden.' },
      { t: 'Stickers en folie', d: 'Van kozijnen, sanitair, deuren en apparatuur, inclusief lijmresten.' },
      { t: 'Cementsluier', d: 'Zure reiniging op tegelwerk, voordat de sluier zich vasthecht.' },
      { t: 'Glas en kozijnen', d: 'Verfspatten en bouwstof eraf, streeploos afgewerkt.', link: '/diensten/glasbewassing/' },
      { t: 'Eerste vloerbehandeling', d: 'Nieuwe vloeren direct beschermen scheelt jaren onderhoud.', link: '/diensten/vloeronderhoud/' },
      { t: 'Sanitair en pantry', d: 'Volledig ontvet en gedesinfecteerd, dispensers gemonteerd en gevuld.' },
      { t: 'Ventilatie en roosters', d: 'Bouwstof zit in de roosters en komt er anders maandenlang uit.' },
      { t: 'Einde huur', d: 'Terug naar de staat die de verhuurder in het contract heeft vastgelegd.' },
    ],
    sections: [
      {
        h: 'Waarom een oplevering in twee rondes gaat',
        p: [
          'Bouwstof is fijner dan huisstof en blijft veel langer in de lucht hangen. Na de laatste zaagsnede daalt dat stof nog dagen neer. Wie het pand een dag na de bouw in een keer schoonmaakt en dan de sleutel overdraagt, levert een pand op dat er bij de inspectie alweer stoffig uitziet, met een discussie tot gevolg.',
          'Wij plannen daarom standaard twee vensters. De grove ronde gaat direct na de laatste bouwpartij: puin, gruis, folie, stickers en het zware werk. Daarna geven wij het pand een paar dagen om uit te dampen en te bezinken. De fijne ronde volgt vlak voor de sleuteloverdracht en pakt precies dat neergedaalde laagje, plus glas en sanitair.',
          'Bij kleine projecten of een strakke planning kan het in een ronde. Dat spreken wij dan expliciet af, inclusief het risico dat er bij de inspectie nog stof gevonden wordt op horizontale vlakken. Wij zeggen liever vooraf wat een ronde wel en niet oplevert dan achteraf.',
        ],
      },
      {
        h: 'Cementsluier en stickerlijm zijn de twee valkuilen',
        p: [
          'Cementsluier is de doffe waas die op tegelwerk achterblijft na het voegen. Vlak na de bouw laat die zich met een zure reiniger eenvoudig verwijderen. Blijft hij maanden zitten, dan hecht hij zich in het glazuur en is er slijpwerk nodig. Dit is de reden dat wij liever kort na de bouw komen dan vlak voor de overdracht.',
          'Stickerlijm op kozijnen en sanitair werkt net andersom. Beschermfolie die te lang blijft zitten, zeker op het zuiden, bakt vast door uv-straling. De lijm laat dan niet meer los zonder oplosmiddel, en op sommige kunststof kozijnen geeft dat blijvende schade. Wij halen folie daarom in de grove ronde weg en niet aan het eind.',
          'Beide punten zijn geen extra werk als u ze op tijd aanpakt en fors extra werk als u dat niet doet. Bij de intake lopen wij daarom eerst langs het tegelwerk en de kozijnen, nog voor wij naar het oppervlak in vierkante meters kijken.',
        ],
      },
      {
        h: 'Nieuwe vloeren meteen beschermen',
        p: [
          'Een nieuwe pvc- of linoleumvloer verlaat de fabriek zonder onderhoudslaag. Wordt het pand in gebruik genomen voordat die laag erop zit, dan begint het schuren van zand direct op het materiaal zelf. Wij brengen daarom bij een oplevering standaard de eerste beschermlaag aan, in twee tot drie lagen, voordat de eerste gebruiker binnenloopt.',
          'Dat is het moment waarop het het goedkoopst is: de vloer is leeg, schoon en volledig toegankelijk. Later hetzelfde doen betekent meubilair verplaatsen en in delen werken. Wie deze stap overslaat, betaalt binnen twee jaar voor een herstelbeurt die nu niet nodig was.',
        ],
      },
    ],
    steps: [
      { t: 'Wij bekijken de planning', d: 'Wij stemmen af met de aannemer wanneer de laatste partij het pand uit is.' },
      { t: 'U ontvangt een offerte per ronde', d: 'Grove ronde en fijne ronde apart, zodat u ziet wat elke stap kost.' },
      { t: 'Wij werken van boven naar beneden', d: 'Plafond, wanden, kozijnen, sanitair, vloer. Andersom werken betekent twee keer werken.' },
      { t: 'Oplevering met u samen', d: 'Wij lopen het pand met u door voor de sleuteloverdracht en nemen restpunten direct mee.' },
    ],
    employee: {
      name: 'Stefan Bakker',
      role: 'Voorman opleveringen',
      quote: 'De vraag die ik altijd stel is wanneer de laatste bouwer eruit gaat. Zolang er nog iemand zaagt, heeft schoonmaken geen zin. Daar valt of staat een oplevering mee.',
    },
  },

  /* ---------------------------------------------------------------- */
  hygieneservice: {
    intro:
      'Een lege zeepdispenser of een op toiletrol is een klein probleem dat elke week terugkomt. Wij nemen het beheer van uw sanitaire voorzieningen over: dispensers, verbruiksartikelen en voorraad. U bestelt niets meer en u komt niets meer tekort.',
    answer:
      'Met de hygiëneservice van Spotlezz houden wij dispensers, toiletpapier, handdoekrollen en zeep op voorraad en vullen wij bij tijdens de reguliere schoonmaakronde. Wij monitoren het verbruik en passen de voorraad aan, zodat u niet meer zelf bestelt en er nooit iets op is. Beschikbaar in Almere, Lelystad, Amsterdam en Amersfoort.',
    facts: [
      { value: 'Bij elke ronde', label: 'Bijvullen' },
      { value: 'Bruikleen mogelijk', label: 'Dispensers' },
      { value: 'Een factuurregel', label: 'Administratie' },
      { value: '< 12 uur', label: 'Reactietijd' },
    ],
    tiles: [
      { t: 'Toiletpapier', d: 'Systeemrollen of standaard, afgestemd op uw dispensers.' },
      { t: 'Handdoekrollen', d: 'Katoen of papier, inclusief wisselen van de cassettes.' },
      { t: 'Handzeep en desinfectie', d: 'Navulling in concentraat, milder voor de huid dan standaard zeep.' },
      { t: 'Dispensers in beheer', d: 'Wij plaatsen, onderhouden en vervangen bij storing.' },
      { t: 'Damessanitair', d: 'Hygiënebakjes met periodieke lediging en reiniging.' },
      { t: 'Luchtverfrissing', d: 'Doseersystemen met navulling, in te stellen per ruimte.' },
      { t: 'Afvalbakken sanitair', d: 'Voorzien van zakken en meegenomen in de ronde.' },
      { t: 'Kleedkamers en douches', d: 'Zeep en papier op een hoger verbruiksniveau ingepland.', link: '/diensten/fitnesscentrum-schoonmaak/' },
    ],
    sections: [
      {
        h: 'Waarom dit bij de schoonmaakronde hoort',
        p: [
          'In de meeste panden zijn schoonmaak en verbruiksartikelen twee gescheiden werelden. De schoonmaker signaleert dat de zeep bijna op is, maar bestelt niet. Iemand van kantoor bestelt, maar loopt niet elke dag langs de dispensers. Daartussen zit precies de week waarin het misgaat.',
          'Als dezelfde persoon die schoonmaakt ook bijvult, verdwijnt dat gat. Onze schoonmaker controleert bij elke ronde de dispensers en vult bij uit de voorraadkast in het pand. Wij houden die voorraadkast op peil op basis van wat er daadwerkelijk doorheen gaat, niet op basis van een vast bestelritme.',
          'Voor u betekent dat een factuurregel in plaats van losse bestellingen bij verschillende leveranciers, en geen voorraadbeheer meer bij een medewerker die daar eigenlijk geen tijd voor heeft.',
        ],
      },
      {
        h: 'Dispensers: houden of vervangen',
        p: [
          'U kunt uw bestaande dispensers gewoon houden, zolang er navullingen voor te krijgen zijn. Wij kijken bij de intake welk merk en welk systeem er hangt en of dat leverbaar blijft. Bij verouderde of exotische systemen betaalt u vaak een veelvoud voor navullingen, en dan is vervangen binnen een jaar goedkoper.',
          'In dat geval plaatsen wij dispensers in bruikleen. U betaalt dan voor het verbruik en niet voor de apparatuur, en wij vervangen bij storing of beschadiging. Wat wij bewust niet doen, is u vastzetten in een gesloten systeem waarbij alleen wij de navullingen kunnen leveren. Als u ooit wilt overstappen, moet dat kunnen.',
          'Bij de plaatsing letten wij op de bereikbaarheid vanaf de wasbak. Een zeepdispenser die te ver van de kraan hangt, geeft druppels op de vloer en dat is een van de meest voorkomende oorzaken van gladde tegels bij sanitair.',
        ],
      },
      {
        h: 'Verbruik voorspellen in plaats van reageren',
        p: [
          'Het verbruik in een pand is redelijk goed te voorspellen zodra u een paar maanden meet. Wij houden per locatie bij hoeveel er doorheen gaat en stemmen de voorraad daarop af, met een marge voor drukke periodes. Zo staat er geen halve kast vol met artikelen die u niet gebruikt, en is er tegelijk nooit iets op.',
          'Sinds hybride werken zien wij grote verschillen tussen dagen. Op een dinsdag gaat er in veel kantoren driemaal zoveel doorheen als op een vrijdag. Daar stemmen wij het moment van bijvullen op af: liever maandagochtend en woensdagmiddag dan een vast tijdstip dat de piek net mist.',
        ],
      },
    ],
    steps: [
      { t: 'Wij inventariseren wat er hangt', d: 'Merk, systeem en aantal dispensers, plus de plek van de voorraadkast.' },
      { t: 'U ontvangt een verbruiksvoorstel', d: 'Op basis van het aantal aanwezigen en het type ruimte, met een prijs per maand.' },
      { t: 'Wij vullen bij tijdens de ronde', d: 'Geen aparte bezoeken, geen extra voorrijkosten.' },
      { t: 'Wij sturen bij op werkelijk verbruik', d: 'Na drie maanden stemmen wij de voorraad af op wat er echt doorheen gaat.' },
    ],
    employee: {
      name: 'Fatima El Amrani',
      role: 'Coördinator hygiëneservice',
      quote: 'Klanten bellen ons niet over schoonmaak. Ze bellen over een lege zeepdispenser. Als je dat oplost, verdwijnen de meeste telefoontjes vanzelf.',
    },
  },
};

/** Twee klantcases per dienst, uit dezelfde branche of met dezelfde dienst. */
export const SERVICE_CASES = {
  glasbewassing: ['kobelco', 'kuchentreff'],
  vloeronderhoud: ['kuchentreff', 'arena-gym'],
  opleveringsschoonmaak: ['kobelco', 'kuchentreff'],
  hygieneservice: ['arena-gym', 'kobelco'],
  'kantoor-schoonmaak': ['kobelco', 'kuchentreff'],
  'hotel-schoonmaak': ['kobelco', 'arena-gym'],
  'showroom-schoonmaak': ['kuchentreff', 'kobelco'],
  'fitnesscentrum-schoonmaak': ['arena-gym', 'kobelco'],
  'kinderopvang-schoonmaak': ['kobelco', 'arena-gym'],
  'vve-schoonmaak': ['kobelco', 'kuchentreff'],
};
