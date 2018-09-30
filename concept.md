Les concepts
---

Dans un premier temps les workflows vont petit à petit remplacer Omega_Services, c'est à dire la programmation des tâches sur le serveur. Le but est de suivre ce qui se passe sur le serveur depuis les postes client.

# Les différents éléments.

## Evénement

Nous avons tout d'abord les événements. Ce sont des déclencheurs, ils peuvent être créés :
* Depuis un bouton de l'application
* A un moment bien défini
* Depuis l'extérieur (service web, ...)

Un événement porte son identité :
* Qui : utilisateur, ...)
* Quoi : le nom de l'objet et son identifiant
* Quand : par défaut immédiat mais peut-être différé
* Comment : en fait plutôt ses propriétés (paramètres, ...)

## Planificateur

Un planificateur est simplement là pour déclencher un événement de manière automatique et unique. Il lance l'événement si il est à déclencher et calcul ensuite le prochain lancement. Ce planificateur pourra être déclencher de manière immédiate en mettant sa date de prochaine exécution à une date passée.

## Workflow

Le workflow le plus simple est l'exécution d'une tâche suite au déclenchement d'un événement. On remarque déjà qu'un simple événement pourra déclencher X workflows.

Lors de l'exécution de la tâche le workflow est en progression, que l'on pourra suivre via l'application. Si la tâche s'est correctement déroulée l'instance du worklow sera marquée comme validée mais passera en erreur dans le cas contraire. L'utilisateur aura donc la vision de ce qui s'est mal passé. On pourra en fonction de l'importance du résultat laisser ou non les workflow validés visibles.

La tâche pourra être :

* une action métier, exécutée soit en direct dans l'application soit sur le serveur (si différé, tâche trop lourde, ...)
* l'appel à un service web
* l'appel à une ressource externe
* ...

## Premières remarques

Les actions métier devront être référencées dans un kit, ainsi que les événements pouvant être déclenchés.

Un workflow pourra se mettre en pause pour attendre une réponse de l'utilisateur. Les réponses possibles seront matérialiées par des événements qui décideront de la suite du workflow.

Ca ne gère à rien de prévoir des places, ... pour gérer les erreurs, il suffit de placer le workflow en erreur pour le stopper.

# Exemple des demandes

Les demandes sont actuellement récupérées via un échange FTP. Le but est d'automatiser cette réception via une tâche qui va s'exécuter soit de manière automatique soit sur demande.

Nous allons passer par une planification (EVE_PLANNING) qui sera chargée d'effectuer cette récupération par défaut tous les soirs. Une planifition peut-être vue comme un cron et on en a pris le principe des 5 "*" (cf doc technique).

Cette planification a une date de prochain lancement. Lorsque cette date est dépassée elle est mise en traitement et l'événement lié exécuté.
