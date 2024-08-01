Voici le document en Markdown mis à jour avec une section sur l'interface d'administration via phpMyAdmin :

---

# Démarrage du Projet

Ce guide vous explique comment démarrer le projet. Veuillez suivre les étapes ci-dessous :

## Étape 0 : Créer votre fichier `.env` en copiant le `.env.example`
```bash
cd src/backend/laravel
cp .env.example .env
```

## Étape 1 : Exécuter le fichier `dev.run.sh`

À la racine du projet, exécutez le fichier shell `dev.run.sh` pour configurer et démarrer les services nécessaires (ils sont dockerisés) :

```bash
sh dev.run.sh
```

## Étape 2 : Démarrer le projet Angular

Après avoir exécuté le script, déplacez-vous dans le répertoire du projet Angular :

```bash
cd src/frontend/angular
```

Ensuite, exécutez la commande suivante pour démarrer le serveur de développement Angular :

```bash
ng s
```

Cette commande démarrera le serveur de développement et l'application Angular sera accessible à l'adresse spécifiée (par défaut, `http://localhost:4200`).

---

### Remarques

- Assurez-vous d'avoir les permissions d'exécution pour le fichier `dev.run.sh`. Si nécessaire, utilisez la commande suivante pour ajouter les permissions d'exécution :

  ```bash
  chmod +x dev.run.sh
  ```

- Assurez-vous d'avoir Node.js et Angular CLI installés sur votre machine. Vous pouvez vérifier leur installation en utilisant les commandes suivantes :

  ```bash
  node -v : 18.19.0
  npm -v : 10.2.3
  ng version : 18.0.7
  ```

- Assurez-vous d'avoir Docker et Docker Compose installés sur votre machine. Vous pouvez vérifier leur installation en utilisant les commandes suivantes :

  ```bash
  docker -v : 25.0.3
  docker-compose -v : 1.29.2
  ```

- Si vous rencontrez des problèmes ou avez des questions, veuillez consulter la documentation ou contacter l'équipe de développement.

---

## Types d'Utilisateurs et Identifiants de Connexion

Le système dispose de trois types d'utilisateurs avec des rôles et des accès différents. Voici les identifiants de connexion pour chaque type :

### Administrateur

- **Nom** : Maestros
- **Email** : maestros@gmail.com
- **Nom d'utilisateur** : maestros21
- **Mot de passe** : PassWord12345

### Manager

- **Nom** : Tino
- **Email** : tino@gmail.com
- **Nom d'utilisateur** : tino
- **Mot de passe** : PassWord12345

### Joueur

- **Nom** : Nina
- **Email** : nina@gmail.com
- **Nom d'utilisateur** : nina
- **Mot de passe** : PassWord12345

---

### Important

**Seuls les administrateurs et les joueurs peuvent accéder à la plateforme pour le moment. Les managers n'ont pas encore accès à la plateforme.**

---

## Interface d'Administration via phpMyAdmin

Le projet inclut une interface d'administration de la base de données via phpMyAdmin. Voici les informations pour accéder à phpMyAdmin :

```yaml
phpmyadmin:
  image: phpmyadmin:latest
  container_name: kimbotest_phpmyadmin
  env_file:
    - ./../../src/backend/laravel/.env
  ports:
    - "8084:80"
  depends_on:
    - db_kimbo_test
  restart: always
  networks:
    - kimbotest-net-dev
```

Pour accéder à phpMyAdmin, ouvrez votre navigateur et rendez-vous à l'adresse suivante :

```
http://localhost:8084
```

Utilisez les identifiants de votre base de données pour vous connecter et gérer vos tables, utilisateurs, etc.
dans le fichier .env.example  nous avon definit les identifiants suivant, mettez les a jours si vous aves changer vos parametres
```
login: userKimboTest
password: oi*Kjhf782^sakjsksHJHJHJdjs**#7623jsd%$*hjs._HJHS
```
ces identifiants vous donnes acces au dashboard phpmyadmin

---
