# Système de Débriefing Laravel (S6_B2)

Application de gestion de rendus et d'évaluations pour les formations Simplon. Permet aux formateurs de gérer les briefs, suivre les livrables des étudiants et effectuer des débriefings détaillés avec évaluation par compétences.

## Fonctionnalités Principales

### 👨‍🏫 Espace Formateur

#### Gestion des Briefs
- **Création & Édition**: Interface complète pour créer des briefs avec titre, contenu, dates de début/fin, type (individuel/collectif) et compétences associées.
- **Assignation**: Les briefs sont liés à des sprints, eux-mêmes assignés aux classes.
- **Suivi**: Vue détaillée par brief avec la liste des étudiants assignés.

#### Suivi & Évaluation
- **Tableau de Bord**: Vue d'ensemble des sprints en cours et des livrables récents.
- **Taux de Rendu**: Visualisation immédiate du pourcentage d'étudiants ayant rendu leur travail pour chaque brief.
- **Correction des Livrables**: Interface de débriefing permettant de :
  - Voir le lien du livrable étudiant.
  - Laisser un commentaire général (avec gestion automatique des retours à la ligne).
  - Évaluer chaque compétence liée au brief (Niveau 1-3 et Statut : À revoir/En cours/Validée).
- **Modification**: Possibilité de modifier une évaluation existante tant que le brief est actif.

#### Analyse de Progression
- **Vue Globale**: Tableau récapitulatif de tous les étudiants de la classe.
- **Détail Étudiant**: Historique complet des briefs, évaluations et commentaires pour un étudiant spécifique.

### 👨‍🎓 Espace Étudiant

#### Tableau de Bord
- **Briefs en Cours**: Accès direct aux briefs actifs avec date limite.
- **Soumission**: Formulaire simple pour envoyer le lien du livrable (Github/Vercel/etc.) et un commentaire.

#### Mon Parcours (Nouveau)
- **Timeline de Progression**: Vue chronologique de tous les briefs passés.
- **Feedback**: Affichage des commentaires de correction du formateur.
- **Validation**: État de validation des compétences pour chaque projet (Code couleur : Vert pour Validée/Acquis, Rouge/Orange pour le reste).

## Stack Technique
- **Backend**: Laravel 10/11
- **Frontend**: Blade + TailwindCSS (Design moderne "Glassmorphism")
- **Base de Données**: PostgreSQL
- **Icônes**: Lucide Icons

## Installation

1. Cloner le dépôt
```bash
git clone [url-du-repo]
cd [nom-du-dossier]
```

2. Installer les dépendances
```bash
composer install
npm install
```

3. Configuration
- Copier `.env.example` vers `.env`
- Configurer la base de données dans `.env`
- Générer la clé d'application: `php artisan key:generate`

4. Migration & Seed
```bash
php artisan migrate --seed
```

5. Lancer le serveur
```bash
php artisan serve
npm run dev
```

## Comptes de Démo (Seeders)
- **Admin**: `admin@admin.com` / `password`
- **Formateur**: `teacher@teacher.com` / `password`
- **Étudiant**: `student@student.com` / `password`
