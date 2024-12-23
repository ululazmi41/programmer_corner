## Programmers Corner

Forum web application that allows users to see posts, join a community, create posts, and interact with comments and likes, the user would also be able to bookmark posts and comments.

Built with:

- **Laravel**
- **TailwindCSS**

Fetures:

- Create, Edit, and remove account
- user profile page
- overview, posts, comments, likes, bookmarks on user profile page
- Trending Posts
- Create, edit, and delete communities
- Create, view, and comments on Posts
- Likes
- Comments
- Bookmarks

## Installation

- Clone the repository.

```sh
git clone https://github.com/ululazmi41/programmer_corner.git
```

- Go into the project root directory

```sh
cd programmer_corner
```

- Copy .env.example file to .env file

```sh
cp .env.example .env
```

- Install dependencies

```sh
composer install
```

- Generate key

```sh
php artisan key:generate
```

- Run migrations

```sh
php artisan migrate
```

- install front-end dependencies

```sh
npm install
```

- Start the development server

```sh
php artisan serve
```

- Start the front-end server

```sh
npm run dev
```

- Open your browser and visit

```sh
http://localhost:8000
```
