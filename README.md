## Programmers Corner

Hybrid forum web application platform allowing users to reigster, create and join communities, create and see posts,  interact with posts, and more. The app is designed to be mobile-responsive.

Built with:

- **Laravel**
- **TailwindCSS**

## Screenshots

![login](/screenshots/1_login.png)
![Home page](/screenshots//2_home.png)
![Create forums](/screenshots//3_create-corner.png)
![forums](/screenshots//4_corners.png)
![view forum](/screenshots//5_corner.png)
![create post](/screenshots//6_create-post.png)
![view post](/screenshots//7_view-post.png)
![User page](/screenshots//user.png)
![notifications](/screenshots//notifications.png)
![chat](/screenshots//chat.png)

## Features

### User Authentication

- **Register/Login**: Users can sign up with an email and password or log in to an existing account.
- **Profile Customization**: Users can update their profile picture, name, username, email, and password.

### Forums

- **Create Forums**: Users can create forums where they can post content and interact with others.
- **Post Content**: Users can create posts in forums. Posts can be commented on, liked, and bookmarked.
- **Commenting & Replies**: Posts have comments, and comments themselves can also be replied to.
- **Notifications**: Each posts, likes, comments, promotions, demotions, and follows will send a notification to the user.
- **Post & Comment Interaction**: Users can like, comment, or bookmark any post or comment.
- **Views Counter**: Every post and comment has a views counter that increases each time it’s viewed.
- **Forum Management**: Forum owners have the ability to rename, change the handle, make a forum private, or delete the forum.

### User Interaction

- **Follow/Unfollow Users**: Users can follow or unfollow others.
- **Following & Followers**: Users can view their following and followers list on their profile page.
- **Private Likes & Bookmarks**: The "likes" and "bookmarks" tabs on the user's profile are private.
- **Chat Groups**: Each forum has its own private chat groups where users can interact in real time.
  - **Join/Leave Groups**: Users can join or leave chat groups.
  - **Group Ownership**: When a forum owner joins a group, they receive the "owner" role.
  - **Admin/Owner Permissions**: Owners and admins can remove users from the chat groups.
  - **System Messages**: The system sends messages when a user joins or leaves a group.

### AJAX Support

- **AJAX-based Actions**: Most actions, such as liking posts, commenting, bookmarking, following users, and interacting with forums, use AJAX to improve the user experience and avoid full-page reloads.
- **Chat Feature**: All actions related to chat (posting messages, leaving groups, etc.) are AJAX-based for real-time updates without page reloads.

### Mobile Responsiveness

- The entire app is fully responsive and optimized for mobile devices using **TailwindCSS**.

## Tech Stack

- **Frontend**: HTML, CSS, TailwindCSS, JavaScript, Laravel Blade
- **Backend**: Laravel
- **Database**: SQLite

## Prerequisites

- php
- Node.js
- Composer

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
