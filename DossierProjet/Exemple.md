# TOUT’O’POILS

#### Applicationd’aideàlagestiondubénévolaten

#### refugeanimalier

_Projetréalisédanslecadredelaprésentationau_

**TitreProfessionnelDéveloppeurWebetWebMobile**

_présentépar_

```
BernardARROUES
O’clock-PromotionKelvin
```


## SOMMAIRE

## SOMMAIRE


- SOMMAIRE
- INTRODUCTION
- LISTEDESCOMPÉTENCESCOUVERTESPARLEPROJET
   - recommandationsdesécurité I.Développerlapartiefront-endd’uneapplicationwebouwebmobileenintégrantles
      - A.Maquetteruneapplication
      - B.Réaliseruneinterfaceutilisateurwebstatiqueetadaptable
      - C.Développeruneinterfaceutilisateurwebdynamique
   - recommandationsdesécurité II.Développerlapartiefront-endd’uneapplicationwebouwebmobileenintégrantles
      - A.Créerunebasededonnées
      - B.Développerlescomposantsd’accèsauxdonnées
      - C.Développerlapartieback-endd’uneapplicationwebouwebmobile
- RÉSUMÉDUPROJET
- CAHIERDESCHARGES
   - I.Besoinsetobjectifsdel’application
      - A.Besoins
      - B.Objectifs
      - C.Cibles
   - II.UsersStories
   - III.Arborescence
   - IV.MVP
      - A.Bénévole
      - B.Administrateur
   - V.fonctionnalitésdétailléesdespages
   - VI.Evolutionspotentielles
      - A.Bénévole
      - B.Administrateur
   - VII.Wireframes
   - VIII.Chartegraphiqueetlogo
   - IX.Exemplesdemaquettes
- SPÉCIFICATIONSTECHNIQUES
   - I.Technologies
   - II.Navigateurscompatibles
   - III.Possibilitésdedéploiement
   - IV.Créationdelabasededonnées
      - A.MCD
      - B.MLD
      - C.Dictionnairedesdonnées
   - V.Routesfrontetback
      - A.Back-end
      - B.Front-end
- RÉALISATIONSPERSONNELLES
   - I.Uploadd’image
      - A.Back
      - B.Front
   - II.Boutondedépartenbalade
- PRÉSENTATIONDUJEUD’ESSAI
- VULNÉRABILITÉSDESÉCURITÉETVEILLE
   - I.Veilletechnologique
      - A.Prisma
      - B.SDKS3etMulter
      - C.NodemaileretserveurSMTP
   - II.Veilledesécurité
      - A.JWTetcryptagedumotdepasseutilisateur
      - B.Utilisationdescaptchasetsécurisationdesrequêtes
   - III.Processusderechercheettraduction
      - A.Processus
      - B.Ressourceenanglais
      - C.Traductioneffectuée
- CONCLUSION
- ANNEXE


## INTRODUCTION

Depuistoutjeune,jesuispassionnéparlestechnologiesetenparticulierlaprogrammation.
Bien qu’ayant suivi un parcours m’éloignant de l’univers del’informatique, j’ai continué
pendant longtemps à m'auto former sur mon temps libre sur les sujets liés à la
programmation.Grâceàcetapprentissageindividuel,j’aipucontinuerlapratiqueducodeet
àsuivrerégulièrementlesactualitésdusecteur.

Aprèsunecertainelassitudedemonprécédentdomained’activité,j’aichoisidetrouverune
voiequimepermettraitdevaliderl’acquisitiond’unecertaineexpérience.Aprèsquelques
recherchessurlesmoyensd’yparvenir,j’aidécidédem’engagerauprèsdel’écoleO’clock.
Aulieudechoisirdesuivrelaformationcomplète,j’aieffectuéuntestdepositionnement
pour accéder directementà lasecondepartie de laformation, avecunespécialisation
back-end.

Aprèsavoirsuivi ceparcourset pourconclurelaformation,l’écoleO’clockmetenplace
l’Apothéose.L’Apothéoseconsisteàréaliserunprojet,pendantunmoisetengroupeavec
d’autresapprenantsdenotrepromotion.C’estdoncàcetteoccasionquenousavonsréalisé
leprojetTout’o’poilsavecmesquatrescollègues.

Au-delà de l’acquisition de nouvelles compétences et lavalidation d’une expérience, je
souhaitaiségalementapprendreàtravaillerengroupesurunprojet.Ayanttoujoursréalisé
despetitsprojetsdefaçonautonome,jesouhaitaisacquérirdesbonnespratiquespourla
réalisationd’untravaildegroupe,etcomprendrel’organisationetlefonctionnementd’une
équipepourunprojet.

En somme, cettepériode deréalisation duprojetTout’o’poilsm’apermisd’acquérirces
nouvellescompétences,toutentravaillantavecuneéquipedequatrespersonnessurun
sujetqui,initialement,nem’auraitpasforcémentintéressésij’avaiseuàlefairedefaçon
autonome.


## LISTEDESCOMPÉTENCESCOUVERTESPARLEPROJET

```
I. Développer la partiefront-end d’une applicationweb ou web
mobileenintégrantlesrecommandationsdesécurité
```
#### A.Maquetteruneapplication

Enamontdelaréalisationàproprementparlerdenotreapplication,nousavonschoisidans
unpremiertempsdetravaillersurlaréalisationdesdocumentsdeconception.

Danscebut,nousavons doncréaliséenpremierlieudesusersstoriespourdéfinirtrès
clairementce quepourront faire lesutilisateurs sur notreapplication.Puisnousavons
réalisé les wireframes du projet, aux formats mobile et desktop pour imaginer la
structurationde nos pages,puis enfinnous avons réalisé unechartegraphiqueetdes
maquettespourvoirconcrètementàquoiallaitressemblernotreapplication.

#### B.Réaliseruneinterfaceutilisateurwebstatiqueetadaptable

Ceprojetétantconçucommeunoutilquotidienàlaréalisationdesactionsdebénévolatau
sein d’une antenne locale de la SPA.Au vu de ladiversité des bénévoles de laSPA,
notammentau niveau del'âge, ilétaitnécessaired’avoiruneinterfacesimpleetfacile
d’utilisation,peuimporteleniveaudecompétenceeninformatique.

Deplus,cetteapplicationétantutile“surleterrain”pourlesbénévoles,ilétaitimpératif
d’avoiruneapplicationcompatibleaveclesformatsd’écranmobile.

#### C.Développeruneinterfaceutilisateurwebdynamique

Auvudesusersstoriesréaliséesenamontdelaréalisationduprojet,ilétaitimpératifque
notre application dispose d’une interface dynamique, dèslors nous nous sommestrès
rapidementtournésverslalibrairieReact.

```
II. Développer la partie front-end d’une application web ou web
mobileenintégrantlesrecommandationsdesécurité
```
#### A.Créerunebasededonnées

Toutcommelaréalisationdumaquettagedel’application,nousavonsvouludèsledébut
organiser lafaçon dont allaientêtrestructuréesnosdonnées.Nousavonsdoncréalisé
commencéparréfléchirauxdonnéesquenoussouhaitionsintégreràl’application,puisnous
avonscrééunMCD,unMLD,ainsiqu’undictionnairedesdonnées.Pourgérerlabasede
donnéesdenotreapplication,nousavonschoisid’utiliserPostgreSQL.


#### B.Développerlescomposantsd’accèsauxdonnées

Pourréaliserlacouched’accèsauxdonnéesdenotreapplication,nousavonsutiliséPrisma.
Pourassurerunversionningdenotrebasededonnées,nousnoussommesservisdel’outil
deversionningintégrédePrisma.

#### C.Développerlapartieback-endd’uneapplicationwebouwebmobile

Pourréaliserleback-enddenotreapplication,nousavonsutiliséexpress.Pourréalisercelà,
nousavonsorganisénotreapplicationavecdifférentesroutes,liéesàdescontrollers.Nous
avons également créé plusieurs middleware, notamment pour l’authentification ou la
validationdesdonnées.


## RÉSUMÉDUPROJET

Chaqueannéedesmilliersdechiensetdechatssontabandonnésetseretrouventdansun
refugeassociatif.Cescentressontgérésauquotidienpardeséquipesprésentestoutau
longdel'annéemaisaussipardesbénévoles.L'organisationinterneendevientcomplexe.

Notre application web nommée « ToutOPoils » a été créée dans le but d'aider ces
associationsquigèrentdesanimauxabandonnés,àl'instardesSPA(SociétésProtectrice
desAnimaux),desfondations(fondationBrigitteBardot)...,àorganiseraumieuxlagestion
desesanimaux,deseséquipementsetdesesbénévoles.

Les animauxétantnombreux,lesassociations n'ontpasforcément demoyenshumains
suffisantspoureffectuerlestâchesquotidiennesrécurrentestellesquelapromenade,les
jeux,lenettoyage....Ellescomptentalorsénormémentsurl'aidedesbénévolesdontelles
n'ontpasnonpluslesmoyensdelesaccompagnerdanslapriseenchargedesmissions.
Ces derniers, après avoir pris connaissance des missions attendues, doivent être
autonomes.

Ainsi,cetteapplicationaétépenséepourpermettreàl'ensembledesbénévolesprésentsde
se positionner entouteautonomiesur lestâchesàeffectueretd'engérersonétat.En
d'autrestermes,ilspourrontveilleràlatraçabilitédestâches.Finilesdoublons,finiles
laisserpourcompteoulespréférences.Toutcepetitmondeseralogéàlamêmeenseigne.
Cette application se veut avant tout pratique, par un gain de temps sur l'accès à
l'information, mais aussi un bon moyen de communication virtuelle car les bénévoles
pourrontinformerinstantanémentetàdistancechaqueactioneffectuée.

En définitive, cette solution favorise la cohérence du travail rendu, un gainde temps
organisationneletunetraçabilité.Maispourl'heure,ceprojetestàdestinationd'uneSPA
précise.


## CAHIERDESCHARGES

### I.Besoinsetobjectifsdel’application

#### A.Besoins

Pourmieuxcomprendrele besoindelaSPA,plusieursrecherchessontnécessairespour
connaîtrel'utilitéduprojet.Ilfautcommencerparconnaîtrel'organisationinternedecette
dernière.

En allant sur le site de la SPA, nous pouvons trouver toutes lesmissions bénévoles
proposées.

LesmissionsbénévolesàlaSPAdiffèrentd'unsiteàl'autre.ChaqueSPAn'apasforcément
lesmêmesbesoins,maisvoicitouteslesmissionsàdestinationdesbénévoles:

```
● Bien-êtredesanimauxsursite
🐾Accompagnementduchien
🐾Accompagnementduchat
```
```
● Entretienetconfortdesanimaux
🐾Entretienetnettoyagedeschenils
🐾Entretienetnettoyagedeschatteries
🐾Entretiendusite,petitstravauxetbricolage
```
```
● Supportbureautique
🐾Accueiletinformationdupublic
🐾Appuiadministratif
🐾Assistancecommunicationdigitale
```
```
● Animationetsensibilisationàlacauseanimale
🐾Animateurpédagogiquejeunesse
🐾Encadrantclubjeunes
🐾Animationsociale
🐾Animations,évènementsetcollectes
```
```
● Bien-êtredesanimauxhorssite
🐾Chatslibres
🐾Accompagnementtransfertsd’animaux
🐾Famillerelais
🐾Visiteurpost-adoption
🐾Visiteurpré-adoptionséquidésetanimauxdelaferme
```
```
● Luttecontrelamaltraitance
🐾Référentdélégué-enquêteur
🐾Délégué-enquêteur
```

#### B.Objectifs

Nouscomprenonsquepouroptimiserlesressourceshumaines,lesinformationsàprendre
connaissancesont:

```
○ Lebénévoledoitpouvoirprendreconnaissancedesmissionsattenduespar
l'association.
○ Lesmissionssontvisiblesviaunsupportdecommunicationmisenplacepar
l'association.
○ Lebénévoledevraêtreautonomesansavoiràsolliciterlesemployés
permanentsdéjàoccupés.
○ Lesbénévolesorganisentlarépartitiondestâchesentreeux.
○ Lebénévoleestenmesuredeconnaîtrelatâchedéjàeffectuéeparun
collègue.
○ L'associationadéterminéleprinciped'organisationcequipermetaux
bénévolesdes'organiserentreeux.
```
Aprèsplusieursrecherches,aucunlogicielsouapplicationsn'existentsurcetypedeprojet,il
existebien-sûrlagestiond'uneassociationmaisquinegèrepasleplanningdesbénévoles.

Nouspouvonséventuellementprendresimplementunplanificateur.Danscecas,lelogiciel«
QO-EZION»est appropriécaril gèrele planningdesbénévolesmaisuniquementsurde
l’événementiel.L'inconvénientpourlaSPAaveccetypedelogicielsseraitéventuellementla
création d’événement pour permettre laplanification et decharger une personnepour
organiserleplanningdechaquebénévole.Danslafoulée,dumêmegenreque«QO-EZION»,
ilya«RECREWTEER»,«VOLUNTEO»...

RevenonssurlesitedelaSPAquiregroupetouslescentresduterritoirefrançaisetoùnous
pouvonstrouvertouteslesinformationsutilesaudéveloppementdenotreproduit.

Eneffet,nouspouvonstrouverlescentresquirecherchentparexempleunbénévolepour
l'accompagnement des chiens et des chats. La recherche renvoie au centre SPA de
BRUGHEAS(03)etaucentreSPAdeCROZON(29).Respectivement,ilya 97 animauxà
adopterdont 36 sontdeschienset 60 sontdeschatset 211 animauxdont 85 sontdes
chienset 117 sontdeschats.

Parceschiffres,nouspouvonsdéjàprendreconnaissancedelatailledelastructureetle
besoinenressourceshumainesetparconséquentlebesoinenbénévoles.Maisaussiquela
SPA a une forte occupation de chiens et de chats, les autres espèces d'animaux
représententenvironmoinsde5%deseffectifsanimaliers.

Ainsi,l'objectifestd'optimiserl'organisationinterneavecpeuderessourceshumainesgrâce
àl'application.


#### C.Cibles

Afind’avoirunebonnereprésentationdelacibledenosutilisateurs,nousavonsétabliun
persona.

```
SébastienLauret 31 ans,Toulouse,Commercial
```
```
Equipementinformatique :tabletteipad,iphone 14
Cequ’ilrecherche :Apportersonexpérienceducommerce
pouraiderlaspasurdesactions
Sanavigation :Ilvaallersurlapageanimation
Cequ’ilattend :Quelesinformationssoientclairesconcernant
lesévénements
Prérequis :Lesitedoitavoirunebonneexpérienceutilisateur
```
```
ElianePetit 75 ans,Paris,Retraitédelafonctionpublique
```
```
Equipementinformatique :Desktopwindows10,mobile
android
Cequ’ellerecherche :S’occuperdeschatsetleurdonnerdel’am
Sanavigation :Ellevaallersurlapaged’accèsauxchats
Cequ’elleattend :Uneapplicationfaciled’utilisation
Prérequis :Lesitedoitavoirunenavigationsimpleet
cohérenteentrelaversionmobileetdesktop
```
```
SarahAïtbaziz 28 ans,Paris,infirmière
```
```
Equipementinformatique :tabletteetmobileandroid
Cequ’ellerecherche :Donnerdesontempslibrepourse
baladeravecleschiens
Sanavigation :Vaallersurlalistedechienetfaireunebalade
Cequ’elleattend :Uneapplicationintuitiveetesthétique
Prérequis :Lesitedoitavoirunaccèsrapideauxbalades
```
```
WillemFeval 45 ans,Lyon,référentSPA
```
```
Equipementinformatique :desktopwindow10,iphone 11
Cequ’ilrecherche :Êtreefficacedanssamissionenversles
animaux
Sanavigation :Accèsadministrateur
Cequ’ilattend :Gagnerdutempsetaccéderrapidementaux
informations
Prérequis :Lesitedoitêtreréactifetpratiquedansla
navigation
```

### II.UsersStories

```
Légende:
MVP
Versionsàvenir
```
**EnTantque Jesouhaite Afinde**

visiteur meconnecteràl’appli accéderauxdifférentsservices

visiteur medéconnecterdel’appli pourlaisserlaplaceàd’autresutilisateurs

utilisateurconnecté accéderàmonprofil modifiermesinformationspersonnelles

bénévole voirlalistedeschiens voirceuxquidoiventêtresortis

bénévole connaîtrelestâches
prioritaires

```
d’apportermonaiderapidement
```
bénévole pouvoirfiltrerles
caractéristiquesdel’animal

```
choisirl’animalcorrespondantàmes
préférences
```
bénévole savoiroujepeuxvoirles
chats

```
leurrendrevisiteetjoueravec
```
bénévole consulterlalistedesanimaux pourvoirleurfiche

bénévole savoirsiunanimalprécisa
étéadopté

```
merenseignersurmonchouchou
(favoris)
```
bénévole signalerunproblème informerauplusvitelesréférentsspa

bénévole savoirsionabesoindemoi
pourunecollecteouautre

```
d’apportermonaide
```
administrateur suivrel’étatdesortiedes
chiens

```
savoirsitousleschienssontsortis
```
administrateur ajouterunanimaldansle
refuge

```
pourqu’ilpuisseavoirunsuivi
```
administrateur attribuerunecageouun
boxàunanimal

```
lelocaliserfacilement
```
administrateur savoirsilescagesoubox
sontnettoyés

```
suivrelapropretédeslocaux
```
administrateur ajouterdesévènements informerlesbénévoles

administrateur voirs’ilyadesproblèmes
avecdesanimaux

```
agirauplusvitepoursasanté
```
administrateur ajouterunbénévole qu’ilpuisseutiliserl’application

administrateur consulterlalistedes
bénévoles

```
pourvoirlesutilisateursinscrits
```

```
administrateur libérerdescageslorsqu’un
animalestadopté
```
```
ajouterunautreanimalalaplace
```
### III.Arborescence


### IV.MVP

NotreProduitMinimum Viables’estnaturellementconstruitautourdelasortiedu
chienetdelavisitedeschatsquisontlecœurdesactivitésdesbénévolesdesrefuges.Pour
cela une authentification sécuriséeest primordiale,ainsi quelesfonctionnalitésliéesà
l’administrateurquipermettentquelesinformationsdonnéesaubénévolesoientdisponibles
etmisesàjour.

**VoicidonclesfonctionnalitésprésentesdansnotreMVP:**

```
● l’utilisateur(bénévoleouadministrateur)doitpouvoirs'authentifieravecunemailet
unmotdepasse
● l’utilisateur doit pouvoir consulter les mentions légales et la politique de
confidentialitédusite
```
#### A.Bénévole

```
● arrivesurlapageaccueil:ildoitpouvoirsortirunchien,visiterlachatterie,accéder
aumenuouaccéderàsonprofil
● poursortirunchien,ildoitpouvoirvoirlalistedeschiensetpouvoirfiltrercetteliste
seloncertainscritères
● unefoissurcettelisteaffichée,ildoitpouvoircliquersurlechiendesonchoixet
ainsivoirsafichecomplète
● surlaficheduchien,ildoitpouvoirconsulterlesinformations(caractéristiquesdu
chien,historiquedesbalades)etvaliderlasortieparunbouton
● unefoislebouton“partirenbalade”cliqué,unepop-updeconfirmationapparaît
● àlafindelabalade,il doitpouvoir cliquersurlebouton "terminerlabalade",et
pouvoirentreruncommentaire(pop-up)sursonexpérienceaveclechien
● pourvisiterunchat,ildoitpouvoirvoirlalistedesboxsetcliquersurleboxdeson
choix pour voir les chats présents,valider son intentionde visite et laisser un
commentairesursavisite(pop-up)
● en cliquant sur la fiche du chat, il doit pouvoir consulter les informations
(caractéristiquesduchat,historiquedesvisites)
```
Danslemenu:
● ildoitpouvoirserendredanslarubrique“voirlesanimaux"etfiltrerselonl’espèce
pourconsulterlafiched'unanimal
● ildoitpouvoiraccéderàsoncompteetmodifiersesinformationsdanslarubrique
"profil"dontlemotdepasse

#### B.Administrateur

```
● arrivesurlapagetableaudebord,ildoitpouvoir:
```

```
● consulterlalistedesanimaux(commepourlebénévole)
● créerunenouvellefichebénévole
● créerunenouvelleficheanimalpourlerentrerdanslerefuge
● consulterlalistedesutilisateurs
● accéderàsonprofilencliquantsurl’avatar(commepourlebénévole)
● pourinscrireunbénévoleildoitpouvoirrécolterlesinformationsnécessairesetlui
envoyerunmaildeconfirmationaveclesidentifiants
● pourentrerunanimaldanslerefuge,ildoitpouvoirenregistrerlesinformationset
caractéristiquesdel’animal
```
### V.fonctionnalitésdétailléesdespages

Les pages/routes sont sécurisées et donc **accessibles seulement à partir du
momentoùl'utilisateurestconnecté** .Seulelapagedeconnexionestaccessiblesurlenet
partoutlemonde.
**Aupréalable,lebénévoledoits'inscrireaurefuge** auprèsd'unemployé(administrateur).Il
reçoitparmailun messagedebienvenueavecsesidentifiants.Ilpourras’il lesouhaite
modifiersonmotdepassedanssapageprofil.

➢ **Pageconnexion:**
Pourlemomentl’utilisateurn’apasl’accèsaumenu.Ildoitcompléterleschamps:

- email
- motdepasse
Ilvalidesonauthentificationgrâce àunbouton.Ilaccèdeàlapaged'accueilsic’estun
bénévoleouàlapagedashboardsic’estunadmin.

➢ **Pageaccueil:**
Cette page estdonc propre au bénévole.Dans lapartie navigation,il peutmaintenant
accéderaumenuetàsapageprofil.Lecorpsdelapageprésentedeuxchoixprincipauxde
redirection:SortirunchienouVisiterlachatterie.

➢ **Pagesortirunchien:**
LapageSortirunchienseprésentesousformedeliste.Elletientcomptedel’expériencedu
bénévole,s’iln’estque“débutant”,ilseralimitéauxchienssociablesetfaciles.Leschiens
apparaissent **parordredeprioritédesortie** etsadatededernièresortieestpréciséesuivant
cescouleurs:

- rouge:urgent,sortidepuis 3 jours
- orange:sortidepuis 2 jours
- vert:sortilaveille
Lechiensortidanslajournéen'apparaîtplusdanslaliste.


Unfiltrepermetégalementaubénévoledechoisirlechienselonsespréférences,selonles
caractéristiquessuivantes:

- sexe
- âge
- gabarit
- tags(correspondantauxtempéraments)

Toutenrestantvigilantauxordresdeprioritédesortiedeschienspourn’endélaisseraucun,
lebénévolecliquesurl'élémentcorrespondantauchienchoisi.
Ilaccèdealorsàsafiche.

➢ **Pagefichechien**
Surlaficheduchienonretrouve:

- sonnom
- lenumérodesonbox
- lesinformationsdonnéesparlerefuge
- sescaractéristiquessousformedetags
- saphotoéventuelle
- lebouton“Partirenbalade”
- l’historiquedesesbalades

Aprèsavoirlulescaractéristiquesduchien,silebénévolelesouhaite,ilpeutcliquersurle
bouton“Partirenbalade”.Acemoment, **lechienestretirédelalistedessorties** etles
autresbénévolesnepeuventpluslevoir.Lebouton“Partirenbalade”précédemmentcliqué
se transforme alors en “Terminer labalade”quidoitêtrecliquéauretour.Cetteaction
déclencheunepop-uppourentreruncommentaireetsonressentiaveclechien.Silebouton
“Terminerlabalade”n’apasétécliqué,lasessionseraautomatiquementferméeaubout
d’uneheure.
Onaffichedansl'historiqueles 4 dernièresbalades.Surchaquebalade,leressentiestvisible
avecuntagdecouleur:

- bon:vert
- moyen:orange
- mauvais:rouge
Ilyaunbouton"voirplus"pourafficherdavantaged’historiques.Onpeutcliquerdirectement
surunebaladepouravoirsondétail,celui-cis'affichealorsendessous.

➢ **Pagevisiterlachatterie**
La page Visiter lachatterie présentela liste desboxes de chats. Ici le bénévole peut
sélectionnerleboxnumérotéqu'ilsouhaitevisiterencliquantdessus.Danscecas,ilest
amenésurlapagecompositiond’unbox.

➢ **Pagecompositiond’unbox**
Cettepageprésentetousleschatsquicomposentleboxetleboutonpermettantdelancer
la“Visite du box”. Lebénévole peutdonc soitcliquersur unefichechatpour voirses
caractéristiquesousurlebouton“Visitedubox”.Commepourlefonctionnementdeschiens,
auclicdecedernierleboutondevient"Terminerlavisite"et **leboxestretirédelapage**


**Visiterlachatterie** .Al'actiondecedernier,lapop-upcommentaireetressentis'affiche.Il
seraaffichédanschaquefichechatcomposantlebox.

➢ **Pageficheduchat**
Surlaficheduchatonretrouve:

- sonnom
- lenumérodesonbox
- lesinformationsdonnéesparlerefuge
- sescaractéristiquessousformedetags
- saphotoéventuelle
- l’historiquedesesvisites(visiteduboxauquelilappartient)

Commepour le fonctionnement deschiens, onaffichedansl'historiqueles 4 dernières
visites.Surchaquevisite,leressentiestvisibleavecuntagdecouleur:

- bon:vert
- moyen:orange
- mauvais:rouge
Ilyaunbouton"voirplus"pourafficherdavantaged’historiques.Onpeutcliquerdirectement
surunevisitepouravoirsondétail,celui-cis'affichealorsendessous.

➢ **Pagevoirtouslesanimaux**
Cettepageprésentelalistedetouslesanimauxprésentssurlesite.Chacundesanimaux
estcontenudansunélémentcliquable(nometphotoéventuelle)quiamèneàlafichede
l’animal.
Ilestpossibledefiltrerlalistevial’espèce.

➢ **Pagetableaudebord**
Letableaudebordpermetàl'administrateurdechoisircequ’ilsouhaitefaire.Enplusd’avoir
accès à son profil dans la partie navigation et à son menu, il peutse joindre aussi
directementsur lespagessuivantes(élémentscliquables):

- voirtouslesanimaux
- créationd’unefichebénévole
- créationd’uneficheanimal

➢ **Pagecréationd’unefichebénévole**
Surlapagecréationd'unefichebénévole,l'administrateurcomplèteleprofildubénévole
avecleschampssuivants:

- nom
- prénom
- adressemail
- motdepasse
- numérodetéléphone
- expérience
Ilenregistreensuitelafichegrâceaubouton“valider”.


```
➢ Pagecréationd’uneficheanimal
Pourcréerlafiched’unanimal,l'administrateurdoitcompléterplusieurschamps:
```
- sonespèce
- sonnom
- sonnumérodebox
- songenre
- sonâge
- sonpoids
- sescaractéristiquessousformedetags
Ilpeutaussipréciserdesinformationsutilespourlebénévoleetajouterunephoto.
Ilenregistreensuitelafichegrâceaubouton“valider”.

```
➢ Pagelistedesutilisateurs
L’administrateuraaccèsàlalistedesutilisateurs,sousformedepetitecarteindividuelle.On
yretrouvepourchaqueutilisateur:
```
- sonnom
- sonprénom
- saphotoéventuelle
- sonétiquette“bénévole”ou“employé”

```
➢ Pageprofil
Toututilisateur(aussibienlebénévolequel’administrateur)peutaccéderàsesinformations
personnellesvialarubriqueprofil.Onyretrouve:
```
- sonnom
- sonprénom
- sonadressemail
- motdepasse
- sonnumérodetéléphone
- saphotoéventuelle
- sonexpérience **sic’estunbénévole**
Unbouton“éditer”permetderendrechaquechampmodifiable.

### VI.Evolutionspotentielles

```
Il est prévud'améliorer l'application par desfonctionnalités complémentaires pour une
meilleure utilisation et une meilleure expérience utilisateur. Les améliorations seront
apportéessurles 2 partiesutilisateurs.
```
#### A.Bénévole

```
● pourraprendreconnaissancedesautresactivitésbénévolestellesquetoutcequia
attraitàl’entretienetleconfortdesanimaux,ausupportbureautique,àl’animationet
lasensibilisationàlacauseanimale
● pourrapeaufinerlalisteenayantlapossibilitédemettreenfavorisonanimalpréféré
etainsiconnaîtresafinalité(ex:adoption)
```

● pourraégalementsignalerl’urgenced’uncommentairedéposésurlafichedel’animal
qui permettra de donner un caractère important et visible rapidement par les
référentsdelaSPA
● pourrasavoirenamontsidesactivitésévénementiellessontprévues

#### B.Administrateur

● auralapossibilitédevoirsilenettoyagedescagesoudesboxontétéeffectués
● pourraajouterlaracedel'animaldanssafiche
● pourracréerlesfutursévénementsafind'informerenamontlesbénévoles
● pourravisualiserl’animalquiaétésignaléparunbénévolecommeétantendanger
afindepouvoirtraiterl’informationrapidement
● pourrasupprimeret/ouarchiverunbénévole
● pourrasupprimeret/ouarchiverunanimal
● pourrachangerleniveaud’expertisedubénévole


##### ●

### VII.Wireframes

```
Pourplusdelisibilité,l’intégralitédeswireframesestdisponibleàl’adressesuivante:
https://whimsical.com/top-formats-desktop-mobile-CuVu8V7ifJsVwWaYizz81w
```
```
Écrandeconnexion
```
```
Accueil
```

```
Sortirunchien
```
_Listedesboxavisiter_


_Compositiond’unbox_

```
Fichechien
```

```
Fichechat
```
_Listeanimaux_


```
Tableaudebord
```
_Créationd’unanimal_


_Créationd’unbénévole_

```
Profil
```

### VIII.Chartegraphiqueetlogo

```
L’application étantprécisémentàdestinationdesbénévolesdelaSPA,l'objectifétaitde
s'approcherdescodesdesonidentité visuelleafindegardercohérenceetharmonie.En
analysantlesitedecettedernièreetennousassurantdesdroitsd'utilisationdelacharte
graphique,nousavonspureprendrelesdifférentestypologiesetcouleursutilisées.
```
```
Pourlelogo,nousavonsfaitlechoixdegarderunvisuelsobre,épuréetmoderne.Pour
rester dans cetteoptique,lapolicecomfortaanousasembléappropriéeetle "O"aété
transformésimplementenempreintesdechienpourfairelelienaveclesanimauxetlaSPA.
```

### IX.Exemplesdemaquettes



## SPÉCIFICATIONSTECHNIQUES

Pour réaliser les spécifications techniques, nous avons tout d’abord réfléchi aux
technologiesquenoussouhaitionsutiliserpourréaliserceprojet.Puisnousnoussommes
penchéssurquelsnavigateursnoussouhaitionsquel’applicationsoitutilisabledemanière
optimale.
Auvudutyped’applicationparticulier,àsavoiruneapplicationuniquementdestinéeàune
antennelocaledelaSPA,nousavonségalementréfléchiàlamanièredontnouspourrions
déployercetteapplication.
Enfinnousavonstravaillésurlesdocumentsliésàlaréalisationdelabasededonnées,puis
àl’architecturedenotreback-endetenfinauxroutesdenotrefront-end.

### I.Technologies

```
● Developerexperience&gestionnairedepaquets
○ Yarn
○ Eslint
○ Prettier
● Front-end
○ React
○ Bootstrap(react-bootstrap)
○ Sass
○ Redux
○ React-router
○ ReactQueryetAxios
● Back-end
○ Express
○ Prisma
○ Joipourlavalidationdedonnées
○ Nodemailerpourl’envoid’email,avecSendInBlueenfournisseurSMTP
```
### II.Navigateurscompatibles

Selonuneétudedemarchéde2022,lesnavigateurslesplusutiliséssont:
● **Surdesktop**
○ Chrome: _57,13%_
○ Firefox: _16,36%_
○ Edge: _11,74%_
**● Surmobile**
○ Chrome: _56,03%_
○ Safari: _30,15%_
Notre application devra donc être compatible avecles versions les plusrécentes des
navigateurscitésci-dessus.
_Source_ :https://www.leptidigital.fr/webmarketing/parts-de-marche-navigateurs-web-10814/#:
~:text=R%C3%A9sum%C3%A9%20de%20la%20r%C3%A9partition%20des%20navigateurs%2
0web%20en%20France%20sur,Edge%20%3A%2011%2C74%20%25


### III.Possibilitésdedéploiement

Plusieurspossibilitésdedéploiements’offrentauclient(SPA),avecdessolutionsplusou
moinsfacilesd’utilisation,etplusoumoinscoûteusestantauniveauhumainquefinancier.
Nousavonsétudié 3 cas:

**1. Ledéploiementenlocal**

```
Avantages Inconvénients
```
```
● Peucher,carnécessite
seulementunordinateur
connectéauréseaulocalet
allumé
```
```
● Possibilitédedéployer
l’ensembledel’applicationassez
rapidement(parexemplevia
Docker)
```
```
● Peuderisquedepiratage
```
```
● Contrôletotalsurlesdonnées
```
```
● Peudedonnées,utilisationd’un
ORMtotalementenvisageable
```
```
● Uniquementutilisablesiles
devicesdesautresutilisateurs
(mobiles,pc,tablettes)sont
connectésaumêmeréseau
local
```
```
● NécessiteuneIPstatiquesurle
réseau
```
```
● Donneuneurlpeulisible( ex:
http://192.168.0.13/animals )
```
```
● Nécessiteunepersonne
maîtrisantbienledéploiement
del’application.Parexemple,
pouréditerlesvariables
d’environnement(ex:serveur
SMTPouidentifiantsd’upload
d’image)
```
```
● Processusdemiseàjourde
l’appafairemanuellement
```
```
Estimationducoûtmensuel: quasimentnul
```

**2. Ledéploiementencloudparl’antennelocaledelaSPA**

```
Avantages Inconvénients
```
```
● Contrôletotalsurlesdonnées
```
```
● Peudedonnées,utilisationd’un
ORMenvisageable
```
```
● Utilisablepartout
```
```
● Leshébergeurscloud
fournissentgénéralementune
URLaccessible(ex:
spa-crozon.vercelapp.com)
```
```
● Unpeupluscherquele
déploiementenlocal,coût
supportéparl’antennelocalede
laSPA
```
```
● Nécessiteunepersonne
maîtrisantbienledéploiement
del’application.Parexemple,
pouréditerlesvariables
d’environnement(ex:serveur
SMTPouidentifiantsd’upload
d’image)
```
```
● Processusdemiseàjourde
l’appafairemanuellement
```
```
Estimationducoûtmensuel:
```
```
Quantité Nom Prix
```
```
2 HerokuBasicDyno
```
- 1 front/ 1 back

##### 14

```
1 HerokuBasicPostgreSQL 9
```
```
1 PluginHerokuSendgrid
```
- envoiemail(serveurSMTP)

```
gratuit (jusqu'à12.000
emails/mois)
```
```
1 AmazonS3
```
- stockaged’images

```
gratuit *
```
```
* Estimationdifficile,varieenfonctiondel’usage
Gratuitpendantles 12 premiersmois(présentationdeAWSS3)
Tarifs:https://aws.amazon.com/fr/s3/pricing/?p=pm&c=s3&z=4
```
```
TOTALMINIMUM=23€/mois
```

**3. LedéploiementencloudcentraliséparlaSPA(SaaS-SoftwareasaService)**

```
Avantages Inconvénients
```
```
● Beaucoupplussimple
d’utilisation
```
```
● Coûtassuméparlesiègedela
SPA
```
```
● Utilisablepartout
```
```
● Nomdedomaineplusclair,ex:
benevoles.spa.fr)
```
```
● Possibilitéd’avoirunsupport
techniqueplusperformantpour
lesbénévolessurleterrain
```
```
● Facilitéàdéployerdesmisesà
jour
```
```
● Centralisationdesdonnées
```
```
● Beaucouppluscher
```
```
● Nécessiteplusieurspersonnes
capablesdegérerle
déploiementetlascalabilitéde
l’infrastructuredel’app
```
```
● Nécessiteraituneréécriturede
l’infrastructuredel’app
```
```
● Legrandnombrededonnées,
l’utilisationd’unORMralentirait
l’application
```
```
Estimationducoûtmensuel:
Il est difficile de fournir une estimation du prix, car l’application
pourraitêtreutiliséeparplusieursmilliersdevisiteursuniquesmensuels.Deplus,le
coût de stockage des données devrait être élevé, la base de données devant
égalementcontenir l’ensemble desdonnées desanimaux, despromenades, des
visites,desboxdetouteslesantenneslocalesdesSPA,cequireprésententplusieurs
milliersd’entrées.
Onpeutégalementimaginerquelecoûtdustockaged’imagesparlebiais
d’unfournisseurdestockagecommeleserviceAmazonS3seraitbienplusélevé,car
facturé à la quantité stockée mais également au nombrede requêtes (lecture,
modifications,etc)surlesimages.
```
Auvuedecetteétude,ledéploiementencloudparl’antennelocaledelaSPAnoussemblele
plusappropriédansunpremiertemps.Eneffet,ildonneunbon compromisentreaccèsà
l’application(utilisationpartout)etlecoût.LedéploiementencloudcentraliséparlaSPA
(SaaS-SoftwareasaService)pourraitêtreenvisagédansunsecondtempssil’application
estutiliséeparbeaucoupdepersonnesmaisnécessiteraitunerestructurationducode.


### IV.Créationdelabasededonnées

#### A.MCD

#### B.MLD

**user** (id,email,password,name,firstname,phone_number,url_image,admin,experience)
**box** (id,type,number,nb_of_places)
**animal** (id,species,name,url_image,age,bio,gender,size,volunteer_experience, **#box_id** )
**walk** (id,date,end_date,comment,feeling, **#user_id** , **#animal_id** )
**tag** (id,name)
**animal_has_tag** ( **#animal_id** , **#tag_id** )
**visit** (id,date,end_date,comment,feeling, **#user_id** , **#box_id** )


#### C.Dictionnairedesdonnées

```
Nomdeladonnée Désignation Type contrainte
```
**code_utilisateur**

```
Codenumériqued'un
utilisateur integer generatedasidentity primarykey
```
courriel Adresseemaild'unutilisateur text notnull

mot_de_passe Motdepassed'unutilisateur text notnull

numéro_telephone

```
Numérodetéléphoned'un
utilisateur text
```
nom Nomdel'utilisateur text notnull

prenom Prénomdel'utilisateur text notnull

lien_photo

```
Urlverslaphotode
l'utilisateur text
```
administrateur

```
Confirmationdustatutadmin
del'utilisateur boolean notnull,defaultfalse
```
experience

```
Niveaud'expériencede
l'utilisateur text
```
```
notnullcheck("beginner","medium","expert"),
default("beginner")
```
**code_animal** Codenumériqued'unanimal integer generatedasidentity **primarykey**

espece Espècedel'animal text notnullcheck("cat","dog","other")

nom Nomdel'animal text notnull

bio Résumédel'animal text

lien_photo Urlverslaphotodel'animal text

etiquette

```
Etiquettedelacaractéristique
del'animal text notnull
```
age Agedel'animal timestamptz

sexe Sexedel'animal text check("male","female")

gabarit Gabaritdel'animal text check("small","medium","big")

Expérience_benevole

```
Expériencedemandéepour
s'occuperdel'animal text notnulldefault'beginner'
```
**code_etiquette** Codenumériquedel'étiquette integer generatedasidentity **primarykey**

nom Nomdel'étiquette text notnull

**code_balade** Codenumériquedelabalade integer generatedasidentity **primarykey**

date Dated'unebalade timestamptz notnull

commentaire Commentairesurlabalade text

ressenti

```
Ressentiavecl'animallorsde
labalade text
```
```
notnullcheck("bad","medium","big")default
("good")
```

**code_visite** Codenumériquedelavisite integer generatedasidentity **primarykey**

date Datedelavisite timestamptz notnull

commentaire Commentairesurlavisite text

**code_box** Codenumériqued'unbox integer generatedasidentity **primarykey**

numero_box Numérodubox

```
alphanuméri
que notnull
```
type Typedubox text

```
notnull,check("chien","chat","autre")default
("other")
```
nombre_de_place

```
Nombredeplacepossible
dansunbox integer notnull,check("chien","chat","autre")default(1)
```

### V.Routesfrontetback

#### A.Back-end

```
ENDPOINT OUTPUT CONTROLLER AUTH
Connexion
```
POST /auth/login Permetdeseconnecter authController.login Non-connecté

```
users
```
GET /users Retournelalistedesutilisateurs

```
usersController.getAllUs
ers Connecté
```
POST /users

```
Utilisateurcréé-onretirelemot
depassedel'objetretourné usersController.create Administrateur
```
GET /users/:id retourneunutilisateur usersController.getOne Connecté

PATCH /users/:id

```
metàjourunutilisateurpuis
retournel'utilisateurmodifié usersController.update Connecté
```
DELETE/users/:id

```
neretournerien(justeunstatus
HTTP204) usersController.delete Connecté
animals
```
GET /animals retourneunelisted'animaux animalsController.getAll Connecté

filtre

```
/animals ?gab
arits=GROS
```
```
retourneunelisted'animauxavec
unfiltrequiretournelesgros
gabarits
```
POST /animals Retournel'animalcréé animalsController.create Administrateur

GET /animals/:id Retourl'animalsélectionné

```
animalsController.getOn
e Connecté
```
GET

```
/animals/:id/w
alks
```
```
Récupèrelalistedesbalades
d'unanimalenparticulier
```
```
animalsController.getWa
lksOfAnimal Connecté
```
PATCH /animals/:id

```
Metàjourlesinformationsd'un
animalenparticulier
```
```
animalsController.updat
e Administrateur
```
DELETE/animals/:id

```
neretournerien(justeunstatus
HTTP204) animalsController.delete Administrateur
walks
```
GET /walks

```
Récupèrelalistedetoutesles
balades walksController.getAll Connecté
```
filtre

```
/walks?animal
_id=:id
```
```
exemple:récupèrelalistede
touteslesbaladesd'unanimalen
particulier
```
POST /walks Créeunenouvellebalade walksController.create Connecté

PATCH /walks/:id

```
Metàjourlesinformationsd'une
baladeenparticulier walksControlelr.update Connecté
```
GET /walks/:id

```
Récupèrelesdétailsd'unebalade
enparticulier walksController.getOne Connecté
```
DELETE/walks/:id neretournerien(justeunstatus animalsController.delete Administrateur


```
HTTP204)
boxes
```
GET /boxes

```
Récupèrelalistedetoutesles
boxes boxesController.getAll Connecté
```
filtre

```
/boxes?type=
CHAT
```
```
exemple:récupèrelalistedes
boxescontenantdeschats
```
POST /boxes Créeunnouveaubox boxesController.create Administrateur

PATCH /boxes/:id

```
Metàjourlesinformationsd'un
boxenparticulier boxesController.update Administrateur
```
GET /boxes/:id Récupèreunbox boxesController.getOne Connecté

GET

```
/boxes/:id/ani
mals
```
```
Retournelesanimauxcontenus
dansunbox
```
```
boxesController.getAnim
als Connecté
```
GET

```
/boxes/:id/visit
s
```
```
Retournelalistedesvisitesd'un
box
```
```
boxesController.getVisit
sOfOneBox Connecté
```
DELETE/animals/:id

```
neretournerien(justeunstatus
HTTP204) animalsController.delete Administrateur
visites
```
GET /visits

```
Récupèrelalistedetoutesles
visites visitsController.getAll Connecté
```
filtre /visits?box=:id

```
exemple:récupèrelalistedes
visitesd'uneboxeenparticulier
```
POST /visits créeunenouvellevisite visitsController.create Connecté

PATCH /visits/:id

```
Metàjourlesinformationsd'une
visiteenparticulier visitsController.update Connecté
```
GET /visits/:id Récupèreunevisite visitsController.getOne Connecté

DELETE/visits/:id

```
neretournerien(justeunstatus
HTTP204) visitsController.delete Connecté
```
#### B.Front-end

```
ROUTE PAGE USER
Connexion
```
/login Pagedeconnexion Non-connecté

```
MenuHome
```
/home Pagehome Bénévole

/walkingdog Pagelistedeschiensàsortir Bénévole

/visits Pagedesboxs Bénévole

/clean Pagenettoyagesdesboxs BénévoleV2

/events Pagedesévénements BénévoleV2

```
MenuDashboard
```
/admin Pagedashboard Admin

/admin/create/user Pageinscriptionbénévole Admin

/admin/create/card Pagecréationd'uneficheanimal Admin


/admin/users Pagelistedesutilisateurs Admin

```
Pagesencommun
```
/animals Pageanimaux Bénévoleetadmin

/animal/:animalId Paged'unanimal Bénévoleetadmin

/box/:id Paged'unbox Bénévoleetadmin

/profile Pageprofil Bénévoleetadmin


## RÉALISATIONSPERSONNELLES

Aucoursdeceprojet,j’aieul’occasiondetravaillersurplusieursdomaines.J’aiévidemment
travaillésurles partiesback etfront del’application,maisentantqueGitMaster,j’aieu
l’occasionde découvrirla gestion deprojetavecGit.Jemesuiségalementoccupédu
déploiementdenotreMVP,ainsiquedelapartieayantattraitàl’uploadetl’hébergement
d’images.Pourcefaire,j’aiapprisàmanierl’infrastructureAWSavecnotammentleservice
S3.

Cependantdeuxpointsontretenumonattentionlorsdelaréalisationduprojet:lesystème
d’uploadd’images,ainsiquelecomposantreactpermettantledépartenbaladed’unchien.

### I.Uploadd’image

Lepérimètredel’envoied’imagecouvrelefrontetleback.Pourexpliquerlafaçondontj’ai
réalisécettefonctionnalité,jevaisenpremierlieuprésenterlagestiondel’envoid’imageau
niveauduback,puislafaçondontjeconstruismarequêted’envoid’imageauniveaudu
front.

#### A.Back

Pourréalisercettefonctionnalité,j’aiutilisélepaquetMulter.Multerestunmiddlewarequi
permetdetraiterl’envoid’imageavecExpress.
Concernantl’hébergementdesimages,j’aichoisid’utiliserleserviceS3d’AmazonAWS.Pour
interagir avec ce service, j’ai utilisé le SDK( _Software DevelopmentKit_ ) d’AWS,et plus
particulièrementlesoutilsliésauserviceS3.

Toutd’abord,j’aicrééunfichierpermettantlacréationdelaconnexionauserviceS3,avec
lesidentifiantsdeconnexionstockésdanslefichier _.env_.

Puisj’aicrééunservicepermettantl’envoidesfichierssurlesbucketsS3.Lesbucketssont
dessortesdecontainersdestockagequenosfichiers,quipermettentdelesclasseren
fonctiondel’utilisationdecesfichiers.


Pournotreprojet,j’aichoisidecréerdeuxbuckets:

- lebucket **animals** :contientlesphotosdesanimaux
- lebucket **users** :contientlesphotosdeprofildesutilisateurs

Auseinduservice,j’aicrééunesimplefonctionquiprendenparamètrelenomdubucketde
destination,etquiretourneunobjetcontenantlesinformationsdubucketciblé,retournant
sonnomainsiquesonURLpublicquipermettradeconstruirel’URLdel’imagequisera
stockéenbasededonnées.

Puis,j’aicrééleserviceenlui-mêmequiseraexportépourpermettreànoscontrollerde
procéderàl’uploadd’imagesurnotreespaceS3.


Onremarquequenotreserviceexporteuneméthode _upload_ quiprendenparamètrelenom
dubucketdedestinationdel’image,l’extensiondel’imageainsiquelecontenudel’image.
Onvoit danscet extrait decode que lafonction _bucketInfo_ définie précédemmentest
appeléepourretournerlesinformationsdubucketvisé.Cesinformationssontutiliséespar
leSDKd’AWSaveclaméthode _send_ .Icil’éléments3ClientfaitréférenceauclientS3quej’ai
crééprécédemment.
Enfin,cettefonctionretournel’URLdel’imagestockéesurlesserveursS3.

Auniveaudescontrollers,j’importedoncmonserviceetjel’utiliseenpassantenparamètre
lebucketdedestination(ici **animals** ),jepassel’extensionquejerécupèreenséparantle
nomdufichierparles“**.** ”,aveclaméthode _split(‘.’)_ et jerécupèreledernierélémentdu
tableauaveclaméthode _pop()_ .Etenfin,jepasselecontenudel’imagequiestpasséau
niveaudelarequêteavec _req.file.buffer_

Onremarqueicil’utilisationde _req.file_ .Cetobjetestpassédanslarequêteparlemiddleware
degestiondesuploadd’images,quiutilise **multer**.


Pourcréerlemiddleware _fileUpload_ ,quitraitelesrequêtescontenantdesimages,j’aicréé
une surcouche de multer pour éviterde devoir pourchaque route passer un objet de
configurationdemulter.

Enfin,au niveau desroutes ou jesouhaitepouvoir permettrel’uploadfichier,j’utilisece
middleware.

Onremarque ici que le middlewareutilise laméthode _single_ deMulterpourindiquer à
expressqu’onsouhaitequele formulairecontienneuniquementunseulfichier,etquece
fichierdoitêtrecontenudansl’élément“image”duformulaire.

Lemiddlewaresechargealorsdestockerl’imageenvoyéeenmémoirevive,puisvérifieque
lefichierestbienunfichierimageaveclesextensionsdefichierautorisées,puiscontinuela
requêteenattachantl’élément _req.file_.


#### B.Front

Lamiseenplacedel’uploadauniveaudufrontresteassezsimple,j’aisimplementajoutéun
champdetype _file_ dansmonformulairedecréationd’unanimal.

Puisunefoisquel’utilisateurvalideleformulaire, jevérifiequeleformulairecontientune
image.Sic’estlecas,jecréeunnouveau **FormData** ,pourenvoyerunformulaireàlaplace
d’unerequêtecontenantdu JSON.Aceformulaire, j’attachel’imagededuchampdéfini
précédemmentainsiquetouteslesautresinformationsquejesouhaitepasserauback.Puis
j’exécutelarequête.


### II.Boutondedépartenbalade

Lacréationdeceboutonmeparaissaitassezsimpledanslathéorie,jedevaissimplement
vérifierquel’utilisateuravaitledroitdepartirenbalade,quel’animaln’étaitpassortidansla
journéeetgérerl’affichaged’unboutonactif“partirenbalade”,ou“terminerlabalade”,ouun
boutoninactif“cetanimalestdéjàsortiaujourd’hui”.

Enréalité,ceboutondevaitgérerplusieursétatsetconditions:

- Leboutonnedoitpasêtrevisiblepourunadministrateur,lesadministrateursn’ayant
    pasledroitdepartirenbalade
- Leboutondoitêtreinactifsil’animalestdéjàsortidanslajournée
- Leboutondoitêtreinactifsil’animalestdéjàencoursdebalade.
- Sic’estl’utilisateurconnectéquiestenbaladeavecl’animal,ildoitpouvoirarrêterla
    balade
- Laduréemaximaled’unebaladeétantdeuneheure,silechienestenbaladedepuis
    plusd’uneheure,leboutondoitafficher“cechienestdéjàsortiaujourd’hui”,mêmesi
    l’utilisateurquipromenaitlechienn’apascliquésur“terminerlabalade”.

J’aidonccrééuncomposant _StartWalkButton_ ,prenantenparamètreunobjetcontenantles
informationsdel’animal,notammentcesdernièresbalades( _animal.walks_ ).


Auniveaudelalogiquedu rendudu bouton,j’encapsulelalogiqueduboutondansune
conditionquivérifiesil’animalestbienpasséenparamètre,etsil’utilisateurn’estpasun
administrateur,auquelcasjeneretournerienetlecomposantn’afficherien.

Dans unpremiertempsonremarquequemapremièreconditionconsisteàvérifierque
l’animaln’aaucunebaladeOUn’estpasdéjàsortidepuisminuitETqu’iln’estpasenbalade.
Ensuite,jevérifiequel’utilisateuraleniveaunécessairepoursortirlechien.Pourcefaire,les
niveauxétantstockésenbasededonnéesenformattextuel(beginner,medium,expert),je


convertisleniveauennombrepourpouvoireffectuerunecomparaisonlogiquegrâceàla
fonction _experienceConverter_.

Sileniveaudel’utilisateurestsupérieurouégalauniveaurequispoursortirl’animal,alors
j’afficheleboutonpourpartirenbalade.

Le composant affiche un simple bouton, qui, une fois cliqué affiche une modale de
confirmation de départen balade.Si l’utilisateur valideledépartenbalade,lafonction
_startWalk_ déclenchelarequêtepourenregistrerlanouvellebaladeenbasededonnées.

Unefoislarequêteeffectuée,jeremplaceladernièrebaladeenregistréedanslestadedu
composantparlanouvellebaladeenregistréepourpermettreàl’utilisateurdevoirlebouton
“terminerlabalade”sansavoiràrechargerlapage.


Enfinaprèsavoirgérélesconditionspourl’affichageduboutondedépartenbalade,jegère
l’étatinverseàsavoirafficherunbouton“terminerlabalade”,sic’estl’utilisateurquiestparti
enbaladeavecl’animaloul’affichaged’unboutondésactivéindiquantquel’animalestdéjà
enbaladeouqu’ilestdéjàsortidurantlajournée.

Surle planthéorique,laréalisationsemblaitsimplemaisc’étaitlagestiondesdifférents
étatsduboutonquirendaitlaréalisationdececomposantdifficile.L’autredifficultérésidait
danslagestiondel’heure,notammentpoursavoirsilechienétaitdéjàsortidanslajournée.
Pour résoudre cette difficulté, j’ai utilisé le module luxon qui permet de manipuler
simplementlesdates,etnotammentaveclaméthode _startOf()_ quipermetdedéterminerle
timestampdudébutd’uneheure,d’unejournée,d’unmoisetc...
Luxonpermetégalementdefairedescomparaisonsaveclesdatesplusfacilementqu’en
javascriptnatif.


## PRÉSENTATIONDUJEUD’ESSAI

Pourillustrerlacréationd’unanimalavecuneimagetéléverséedepuisl’ordinateurduclient,
voiciunjeud’essaiquipermetdevérifierlebonfonctionnementdelarequête.
Pourréalisercejeud’essai,jevaismeservirdulogicielPostmanquipermetdetester,etde
documentslesrequêtesversuneAPI.

Dansunpremiertemps,j’observel’étatactueldenotrebasededonnées,avantl’ajoutde
l’animal.Latablequiseramiseàjourlorsdelacréationd’unanimalestlatable“ _Animal_ ”.


Larequêtedecréationd’unanimaln’étantautoriséequepourlesadministrateurs,jedois
toutd’abord récupérerunJWT quejevaisensuitepasseràmarequêtedecréationd’un
animal.
J’effectuedoncunerequêteversl’endpointderécupérationdutoken,avecmesidentifiants
administrateur.

Ensuite,jevienscréerlarequêtedecréationdel’animal,jevaistoutd’abordajouterleJWT
récupérédansl’onglet“Authorization”dePostman.

J’aisélectionnéicientyped’autorisation,leformat“BearerToken”,decettefaçonPostman
vaajouterunheadersuivantceformat:“Authorization:Bearer[monJWT]”,l’APIseraalors
capabledecomprendreleformatetdeletraitercorrectement.

Ensuite, jepasse àl’ajoutdesdonnéesqueje souhaiteenvoyeràmonAPI.Commevu
précédemment,pourajouteruneimagejedoisutiliserletype“formulaire”,etnonpasletype
JSONcommepourlerestedemonAPI.
DansPostman,jevaisalorssélectionnerletype“form-data”,dansl’onglet“Body”.Ensuite,j’y
ajouteleschampsquejesouhaitepasserenparamètre,ainsiqu’unchampdetype“file”,
aveclenom“image”.


Lesdonnéesattendueslorsdelacréationdel’animalvial’APIdoiventrespecterlescritères
suivants:

- RéponseauformatJSON
- UnstatutHTTP 201
- Lesdonnéesentrées
- L’identifiantdel’animalenbasededonnées
- L’URLdel’image,pointantversunserveurS3d’AWS.

J’effectuemarequêteetj’observelaréponsedemonAPIavecPostman:


LaréponsedemonAPIestunstatutHTTP 201 - Created,auformatJSON.LeformatJSON
contientbienlesdonnéesentrées,ainsiquel’IDdel’animaletunlienversnotrestockage
S3.

Pourvérifierquetoutestcorrecte,jevaisvérifierl’étatdenotrebasededonnées,ainsique
surl’application.



## VULNÉRABILITÉSDESÉCURITÉETVEILLE

### I.Veilletechnologique

#### A.Prisma

Aucundesmembresdenotreéquipen’ayantd’expérienceavecPrisma,nousavonsdûlors
delaréflexionsurlestechnologiesquenoussouhaitionsutiliserpourréalisernotreprojet.
Initialement, nous pensions nous orienter vers du SQL pur, mais nous pensions
éventuellementàutiliserPrisma.Nousavonsdonccommencéparfairedesrecherchessur
les avantages et les inconvénients de ces deux hypothèses. Le sujet étant assez
“dogmatique”,nousavonseffectué nosrecherchesdenotrecôtéavantdedébattreentre
nous.J’ainotammentutiliséleslienssuivants:

- https://www.prisma.io/docs/concepts/overview/why-prisma:table de comparaison
    dePrismaaveclesautresORM,réaliséparl’équipedePrisma
- https://stackoverflow.com/questions/72109628/orm-or-raw-sql-which-one-is-better

Auvudutempsquinousétaitdonnéetlacomplexitéquepouvaitentraînerl’utilisationde
requêtesSQLpure,nousavonsoptépourPrisma.L’autreintérêtdePrismarésidaitdansson
outildeversionnagedebasededonnées.

#### B.SDKS3etMulter

Ayantlachargederéaliserlafonctionnalitéd’envoid’images,j’avaisdéjàentenduparlerde
MulteretduservicedestockageS3,sanspourautantl’avoirutilisé.

J’aidonccherchéàvoircommentcessolutionspouvaients’articuleravecnotreprojetetla
basedecodedéjàexistante:

- https://levelup.gitconnected.com/file-upload-express-mongodb-multer-s3-7fad4dfb3
    789

Aprèsavoirvucetarticle,jemesuisréféréàladocumentationduSDKd’AWSS3ainsiqu'àla
documentationdeMulterpourréaliserlamiseenœuvredecettefonctionnalité.

- https://docs.aws.amazon.com/sdk-for-javascript/v2/developer-guide/s3-node-exam
    ples.html
- https://docs.amazonaws.cn/en_us/sdk-for-javascript/v2/developer-guide/getting-sta
    rted-nodejs.html
- https://www.npmjs.com/package/multer

Initialementjepensaispouvoirtransférerdirectementlesdonnéesdel’imagedelarequête
verslesserveursS3sansavoiràstockerlesimagessurleserveurdel’APIouenmémoire.

- https://www.npmjs.com/package/multer-s3
Cependantjemesuisrenducomptelorsdelamiseenplacedecettefonctionquel’upload
étaiteffectuéauniveaudumiddlewaredeMulter,orjesouhaitaispouvoirvérifierauniveau
ducontrollerquel’utilisateuravaitl’autorisationdetéléverserunimage,parexemplepourla
créationd’unanimal,quiestréservéauxadministrateurs.


J’aidoncdécidédefairemachinearrièrepourreveniràunesolutionplusclassique,àsavoir
conserverl’imageenmémoire,passerlarequêteaucontrolleretsil’utilisateuralesdroits,
uploaderl’imagesurlesserveursS3viasonSDK.

#### C.NodemaileretserveurSMTP

L’unedesfonctionnalitésdenotreapplicationconsisteàenvoyerunmailàunutilisateur
pourl’informerdesoninscriptionsurl’application.

Je me suis tout d’abord penché sur la solution d’envoi d’email Nodemailer avec sa
documentation,ainsiqued’autreressources:

- https://nodemailer.com/
- https://mailtrap.io/blog/sending-emails-with-nodemailer/
Enfin,jesouhaitaiséviterde“polluer”labasedecodedel’application,en“découplant”le
templatedumaildelafonctiond’envoidumaildenodemailer.

J’aitrouvé lapossibilité d’utiliser un moteurde templates (handlebars)avecun simple
adaptateurpourNodemailer:

- https://medium.com/how-tos-for-coders/send-emails-from-nodejs-applications-using
    -nodemailer-mailgun-handlebars-the-opensource-way-bf5363604f54
- https://www.npmjs.com/package/nodemailer-express-handlebars

### II.Veilledesécurité

#### A.JWTetcryptagedumotdepasseutilisateur

Pourréaliserlesystèmedeconnexiondel’utilisateur,nousavonschoisid’utiliserlesJson
WebTokens(JWT),nousnousposionségalementlaquestiondelasécuritédustockagedes
motsdepassedesutilisateursenbasededonnées.

Aprèsavoireffectuéquelquesrecherchessurlesfaçondestockerlesmotsdepasse,nous
avonsdécidédeleshasherenutilisantlalibrairiebcrypt.

- https://blog.logrocket.com/password-hashing-node-js-bcrypt/
- https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_S
    heet.html#hashing-vs-encryption

Puisnousavonseffectuédesrecherchessurlesbonnespratiquesàadopterenmatièrede
sécurisationdesJWT:

- https://curity.io/resources/learn/jwt-best-practices/
- https://cheatsheetseries.owasp.org/cheatsheets/REST_Security_Cheat_Sheet
    .html#jwt
- https://stackoverflow.com/questions/27301557/if-you-can-decode-jwt-how-a
    re-they-secure
Enfin, nous avons cherché à savoir quelles sont les bonnes pratiques en matière de
transmissionduJWTentrelefrontetleback.
- https://levelup.gitconnected.com/bearer-token-authentication-and-authorizati
on-6e4d16890833


#### B.Utilisationdescaptchasetsécurisationdesrequêtes

Lorsdelaréalisationdelapartiefront-end,nousnoussommesposélaquestiondesavoirsi
l’utilisationdecaptchasauniveauduformulairedeconnexionétaitpertinente.

- https://datadome.co/bot-management-protection/traditional-captcha-obsolete/
- https://www.cloudflare.com/learning/bots/how-captchas-work/
- https://support.google.com/a/answer/1217728?hl=en#:~:text=CAPTCHA%20helps%
    20protect%20you%20from,into%20a%20password%20protected%20account.

Aprèscesrecherches,nousavonscomprisquelescaptchasétaientunepremièreprotection
au niveaude lapartie front de l’applicationpour empêcher desrobotsmalveillantsde
pouvoiropérerdesattaquesdetypebruteforce.

Cependant, cetteprotection neconcerneque lapartiefront-end denotreapplication,la
partieback restantouverteàdesattaques.Atitre personnel,j’auraissouhaitéquenous
mettionsenplaceunsystèmederate-limitingauniveaudenotreAPI,ainsiquelamiseen
placederèglespluscontraignantesauniveaudesCORS.Auvudutempsquinousétait
impartipourréaliserceprojet,nousn’avonspaseuletempsdeprocéderàcesajouts,mais
cesajoutspourraientêtreintégrésdansunemiseàjourdenotreapplicationquirespecterait
aumaximumlesbonnespratiquesdesécuritéétabliesparlafondationOWASP.

- https://www.cloudflare.com/learning/bots/what-is-rate-limiting/
- https://auth0.com/blog/cors-tutorial-a-guide-to-cross-origin-resource-sharing/
- https://cheatsheetseries.owasp.org/

### III.Processusderechercheettraduction

#### A.Processus

Poureffectuermesrecherches,j’adopteengrandepartieleprocessusderecherchesuivant:

1. Requêteenanglais,plutôtqu’enfrançais,surgoogleavecdestermessimples
2. Sélectiondessourcesparrapportauclassementpersonnel,ainsiqueladatede
    création/miseàjourdelasource
3. Analysecritiquedesinformationscontenuesdanslespagessélectionnées

Enrèglegénéraljesélectionnelesressourcesdansl’ordresuivant:

1. Ladocumentationdelatechnologie
2. Un acteur ou un groupe d’acteurs connus et identifiés dans le domainede la
    recherche,parexemple lafondationOWASPdanslecadred’unerecherchesurla
    sécurité
3. Lessitesayantattraitàlaprogrammation, _exemple:medium,blogLogRocket,etc._
4. Éventuellement des questions sur Stackoverflow, mais je préfère éviter Stack
    Overflowquandils’agitdequestionsliéesaucodeenlui-même,cependantj’apprécie
    lesdifférencesdepointsdevuesurdesquestions“théoriques”.

```
Pourillustrercettepratique,jevaisreprendrel’interrogationdemonéquipequantà
l’utilisationdeprisma.
```

Dans un premier temps, j’effectue une requête simple pour aborder ce
questionnement:

Ensuitej’observelesrésultats,lapremièreestladocumentationdePrisma,jegarde
cependant à l’esprit que cesujet estouvert à interprétationje décide donc de
consultercettepagedeladocumentationdePrisma.

Maiscesujetétantsourcededébats,jeregardeégalementlesquestionsdeStack
Overflowpourtenterd’avoird’autrespointsdevue.


#### B.Ressourceenanglais

```
Danslecadredecetterecherche,voicil’extraitquej’aichoisidetraduire.Ilest
issudeladocumentationdePrisma:
```
```
https://www.prisma.io/docs/concepts/overview/why-prisma
```
```
RawSQL:Fullcontrol,lowproductivity
WithrawSQL(e.g.usingthenativepgormysqlNode.jsdatabasedrivers)
youhavefullcontroloveryourdatabaseoperations.However,productivity
suffersassendingplainSQLstringstothedatabaseiscumbersomeand
comes with a lot of overhead (manual connection handling, repetitive
boilerplate,...).
```
```
Anothermajorissuewiththisapproachisthatyoudon'tgetanytypesafety
foryourqueryresults.Ofcourse,youcantypetheresultsmanuallybutthis
isahugeamountofworkandrequiresmajorrefactoringseachtimeyou
changeyourdatabaseschemaorqueriestokeepthetypingsinsync.
```
```
Furthermore,submittingSQLqueriesasplainstringsmeansyoudon'tget
anyautocompletioninyoureditors.
```
#### C.Traductioneffectuée

**SQLPur:contrôletotal,productivitéfaible**

```
AvecleSQLpur(parexempleenutilisantlesconnecteursNodeJSdebase
de données telle que pg ou mysql) vous avez le contrôle total des
opérationseffectuéessurvotrebasededonnées.
Cependant,lefaitd’utiliserdesrequêtesSQLtextuellesvientimpactervotre
productivité, vous devez effectuer destâches lourdes et chronophages
(gérerlaconnexion,code“boilerplate”,...)
```
```
Unautredesinconvénientsdecetteapprocherésidedanslefaitquevous
n’avezpasdetypagededonnéespourlesrésultatsdevosrequêtes.Bien
sûr,vouspourrieztyperlesrésultatsmanuellement,maiscelàdemandeun
travailénormeetdemandeunerefonteimportantedevotrecodedèslors
quevousmodifiezleschémadevotrebasededonnéesoulesrequêtesque
vouseffectuez.
```
```
De plus,gérer vos requêtes SQLde façon textuelle implique quevous
n’aurezpasd’autocomplétiondevotrecodedansvotreéditeur.
```

## CONCLUSION

Enconclusion,j’aimeraisavanttoutremercierAngélique,Luis,MathildeetDenisequiontété
mescollèguessurceprojet.L’émulationd’idéeset detechniquesliéeànosexpériences
passéesàpermisdeconstruirerapidementetefficacementlaméthodologiedetravailqui
allaitnousaccompagnerdurantcemoisdecréationduprojet,etceenrépondantàune
problématiquedéjàvécueparAngélique,notreproductowner.Lefaitd’avoirmisenplace
cesbonnesbasesdegestiontrèsrapidementnousapermisderéfléchiretdeco-construire
lesréponsesquenoussouhaitionsapporteràlaproblématiquedelagestiondesactionsde
bénévolat au sein des antennes locales de la SPA, ou plus globalement desrefuges
animaliers.

Bienqueceprojetnousposaitdes“défis”techniques,carnousabordionsdestechnologies
quenousavionspeuoupasdutoututiliséesprécédemment,nousavonsréussiàcumulerla
recherche sur le fonctionnement deces technologies, avec le développement denotre
projet.

Initialement,j’appréhendaiscettepériodedeconstructionengroupe,àdistance,surune
duréeàlafoislongue,maiscourteauvudel’ambitionduprojet.Al’issuedecettepériode,
j’étaisabsolumentconvaincudel’importancedecetteexpérience,etlesbonnespratiques
qu’elleapum’apporterpourmonexpérienceprofessionnelle.


## ANNEXE

Lesreposduprojetsontaccessiblesàcetteadresse:https://github.com/toutopoils
Leprojetestaccessibleàl’adressesuivante:http://toutopoils.herokuapp.com/

##### RÔLE EMAIL MOTDEPASSE

```
Administrateur admin@toutopoils.fr administrateur
```
```
Bénévole benevole@toutopoils.fr benevoles
```
LefrontetlebacksontdéployéssurdeuxinstancesHeroku,tandisquelabasededonnées
esthébergéesurRender.
