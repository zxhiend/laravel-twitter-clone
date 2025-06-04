# Mini-Twitter (Laravel Edition) 🐦

A stripped-down clone of Twitter/X built for an academic **Back-End Programming** course.  
The aim is to demonstrate how core social-media features can be modelled and implemented with **Laravel 11, MySQL, Redis, and WebSockets**—while keeping the code clean, well-tested, and well-documented.

---

## ✨ Feature Roadmap

| Tier | Module | Status | Description |
|------|--------|--------|-------------|
| **MVP** | Auth & Profile | [ ] | JWT/Sanctum-based register & login, view/edit profile |
|        | Tweet Service   | [ ] | CRUD for tweets (text + optional media) |
|        | Follow Graph    | [ ] | Follow / unfollow, list followers & following |
|        | Home Timeline   | [ ] | *Fan-out-on-read* feed of own + followee tweets |
| **Nice-to-Have** | Engagements | [ ] | Likes, retweets, threaded replies |
|                | Search + Trends | [ ] | Full-text search & simple hashtag ranking |
| **Stretch** | Notifications | [ ] | Event-driven “X liked your tweet” inbox |
|            | Direct Messages | [ ] | Real-time 1-to-1 chat via WebSockets |

> **Tip :** Finish MVP first (Auth ➜ Timeline). Add the rest if time allows.

---

## 🏗️ Tech Stack

| Layer       | Choices                                       | Why |
|-------------|-----------------------------------------------|-----|
| Framework   | **Laravel 11** (PHP 8.3)                      | Batteries-included Auth, Queue, Broadcast |
| Database    | **MySQL 8**                                   | Familiar ACID SQL with FULL-TEXT support |
| Cache/Queue | **Redis 7**                                   | Home-timeline cache & async jobs |
| Search      | **MeiliSearch** (Laravel Scout driver)        | Lightweight, easy to spin up |
| Real-time   | **Laravel WebSockets** + **Echo**             | DM & live like/retweet counters |
| Testing     | **PestPHP** + Laravel test helpers            | Fast, readable tests |
| CI          | **GitHub Actions**                            | Lint, static analyse, run unit tests on every push |
| Container   | **Laravel Sail** (Docker)                     | One-command local setup |

---

Tech Stack may change upon further discussion
