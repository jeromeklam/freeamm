# Workflow - Windev

Nous abordons dans cette documentation l'implémentation code sources, en aucun cas la formalisation du workflow ni les concepts associs. On considère que le workflow est créé et maîtrisé.

Dans Windev vous devrez intégrer les deux composants suivant :
* OMEGA_Common (pour la partie commune)
* OMEGA_Queue (pour la gestion des files d'attente et des workflows)

Ces composants sont autonomes et disposent d'une base de données, base de données gérée par les composants.

## Intégrer les composants

Avant de commencer nous allons donc intégrer les deux composants au projet.
Dans notre cas nous utiliserons une base ORACLE avec les informations de la connexion courante, mais le composant peut supporter d'autres bases.

### Instancier le composant

Il faudra ensuite instancier un minimum d'objets :

```
// Initialisation du composants
//
PROCEDURE GLOBALE PUBLIC initComposantQueue(local p_cnx_String est une chaine, local p_user est une chaine, local p_password est une chaine)

RETOUR = Faux

OMEGACommonDI::debug("InitComposantQueue")
QUAND EXCEPTION DANS

	LOCAL
		oQueue 	est un OMEGAQueue dynamique = Null
		cnx 	est un OMEGACommonCnxOracle(p_cnx_String, p_user, p_password)

	OMEGACommonDI::debug("InitComposantQueue =" + p_cnx_String)
	OMEGACommonDI::debug("InitComposantQueue =" + p_user)
	// Je transmet les infos au composant
	OMEGACommonDI::setConnexion(cnx)

	// Démarrage
	OMEGACommonDI::debug("InitComposantQueue.before.getInstance")
	oQueue = OMEGAQueue::getInstance()
	OMEGACommonDI::debug("InitComposantQueue.after.getInstance")
	RETOUR = Vrai
FAIRE
	OMEGACommonDI::error(::a_queueErreur)
FIN
```

### Logger

Nous voyons ci-dessus l'utilisation d'une classe OMEGACommonDI qui est l'injecteur de dépendances. Il dispose de certaines méthodes dont les méthodes centrales le "log". De base le mécanisme de log n'est pas activé et ces appels ne font rien. Pour ajouter, par exemple, des logs dans un fichier ajouter ces lignes en début du projet :

```
unLogger est un OMEGACommonFileLogger(ComplèteRep(fRepExe()), "trace.log")
OMEGACommonDI::setLogger(unLogger, OMEGACommonDI::LOG_LEVEL_DEBUG)
```

## Déclencher un évenement

Le point de départ d'un workflow est son événement déclencheur. Pour déclencher un événement nous allons utiliser une méthode spécifique de la classe OMEGAQueue : fireEvent

Cette méthode nécessite deux paramètres :
* Le nom de l'événement (qui est fourni via l'application via un fichier kit de données pour l'import en clientèle). Ces noms peuvent par exemple être des constantes d'une classe, ... Evitez les valeurs en "dur" dans les sources
* Un objet OMEGAQueueObject qui va contenir les informations nécessaires au lancement de l'événement. Les paramètres, l'utilisateur, ...

Voici le prototype de cette fonction :

```
// Résumé : Exécution d'un événement
// Syntaxe :
//[ <Résultat> = ] fireEvent (<p_eve_name> est chaîne, <p_data> est OMEGAQueueObject [, <p_thread> est booléen])
//
// Paramètres :
//	p_eve_name (chaîne ANSI) :Evénement
//	p_data (OMEGAQueueObject) :Données liées à l'événement
//	p_thread (booléen - valeur par défaut=0) :<indiquez ici le rôle de p_thread>
//
// Valeur de retour :
// 	booléen : Vrai en cas de publication
PROCEDURE fireEvent(p_eve_name est une chaîne, p_data est un OMEGAQueueObject, p_thread est un booléen = Faux)
```

Il sera également possible d'exécuter un événement en local via un processus en parallèle. Il suffit de positionner le dernier paramètre à Vrai.

### Compléter l'instance OMEGAQueueObject

Avant de commencer voici les champs obligatoires :
* L'identifiant : setId()
* Le thème : setTheme()
* L'utilisateur : setUserId()

Ensuite il existe la possibilité, si nécessaire, de passer des paramètres.
Il existe plusieurs approche pour compléter les paramètres de cet objet.

#### A partir des données en base

La première technique consiste à demander à la base de données de nous retourner un objet pré rempli. Le but étant d'avoir un objet contenant la liste de tous les paramètres de toutes les "éléments" liés à cet événement.

```
LOCAL
    oObj est un OMEGAQueueObject dynamique = Null

oObj = OMEGAQueueObject::getNewByEveName("TESTEVENT")
```

#### En précisant soit même les Paramètres

```
LOCAL
    oObj est un OMEGAQueueObject

oObj.addOrUpdateFieldValue("param1", "Val1")
oObj.addOrUpdateFieldValue("param2", "Val2")
```

## Le prototype des fonctions liées aux souscriptions

Toutes les fonctions doivent avoir le même prototype. Voici un exemple :

```
PROCEDURE GLOBALE wait100(LOCAL oPub est un OMEGAQueueInterfacePublication dynamique)

POUR i = 1 A 10
	oPub.updateProgress(i + " / 10")
	Multitâche(1000)
FIN

RENVOYER OMEGAQueueInterfacePublication::STATUS_OK
```

Les règles :
* Procédure globale (d'une classe ou d'une collexction de procédures)
* Un paramètre de type OMEGAQueueInterfacePublication dynamique
* Retourner un status de la classe OMEGAQueueInterfacePublication

Pour retourner une erreur on peut soit retourner un ::STATUS_ERROR ou déclencher une exception. Les exceptions sont donc gérées au niveau supérieur.
