# Blogging-Website-Laravel-API

Main Point:
Authentication is done through laravel sanctum for both (Main User, Admin)
Then automaticaly store the token through beraer in middleware/authentication and then override the handle function by storeing jwt token

Main User:
1. User will be registered and then authenticated through jwt token and then user can create post and can also comment on everypost and also edit his own comment
2. User can only view his/her own post, delete his post, and also comment but not someone's other account.

Guest User:
1. for guest users, they can also view all post and also comment on someones post.

Admin User:
1. User will be registered and then authenticated through jwt token and admin can delete post, comment and user too and also update the user only.
