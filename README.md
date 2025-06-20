# Mini-Twitter (Laravel Edition) 🐦

A stripped-down clone of Twitter/X built for an academic **Back-End Programming** course.  
The aim is to demonstrate how core social-media features can be modelled and implemented with **Laravel 12, MySQL, Redis, and WebSockets**—while keeping the code clean, well-tested, and well-documented.

---

## ✨ Feature Roadmap

| Tier             | Module          | Status | Description                                           |
| ---------------- | --------------- | ------ | ----------------------------------------------------- |
| **MVP**          | Auth & Profile  | [x]    | JWT/Sanctum-based register & login, view/edit profile |
|                  | Tweet Service   | [-]    | CRUD for tweets (text + optional media)               |
|                  | Follow Graph    | [x]    | Follow / unfollow, list followers & following         |
|                  | Home Timeline   | [x]    | _Fan-out-on-read_ feed of own + followee tweets       |
| **Nice-to-Have** | Engagements     | [x]    | Likes, retweets, threaded replies                     |
|                  | Search + Trends | [x]    | Full-text search & simple hashtag ranking             |
| **Stretch**      | Notifications   | [ ]    | Event-driven “X liked your tweet” inbox               |
|                  | Direct Messages | [ ]    | Real-time 1-to-1 chat via WebSockets                  |

> **Tip :** Finish MVP first (Auth ➜ Timeline). Add the rest if time allows.

---

## 🏗️ Tech Stack

| Layer       | Choices                                | Why                                                |
| ----------- | -------------------------------------- | -------------------------------------------------- |
| Framework   | **Laravel 12** (PHP 8.3)               | Batteries-included Auth, Queue, Broadcast          |
| Database    | **MySQL 8**                            | Familiar ACID SQL with FULL-TEXT support           |
| Cache/Queue | **Redis 7**                            | Home-timeline cache & async jobs                   |
| Search      | **MeiliSearch** (Laravel Scout driver) | Lightweight, easy to spin up                       |
| Real-time   | **Laravel WebSockets** + **Echo**      | DM & live like/retweet counters                    |
| Testing     | **PestPHP** + Laravel test helpers     | Fast, readable tests                               |
| CI          | **GitHub Actions**                     | Lint, static analyse, run unit tests on every push |
| Container   | **Laravel Sail** (Docker)              | One-command local setup                            |

---

Tech Stack may change upon further discussion

## Guide

1. Clone this repository
2. Cd into the folder
3. Run `composer install && npm install`
4. Copy `.env.example` to `.env`
5. Change `DB_PASSWORD` to your MySQL password
6. Run `php artisan key:generate`
7. Run `php artisan migrate`
8. Run `php artisan storage:link`
9. Install Meilisearch if you haven't already
    ```sh
    curl -L https://install.meilisearch.com | sh
    ```
    or if you're running windows download from here: https://github.com/meilisearch/meilisearch/releases
10. Run Meilisearch
    ```sh
    ./meilisearch --master-key="aSampleMasterKey"
    ```
11. Run `composer run dev` on another terminal
