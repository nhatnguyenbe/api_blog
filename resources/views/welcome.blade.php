<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config("app.name")}}</title>
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <div class="container mx-auto p-4">
            <h1 class="text-center">Resources Blog API</h1>
            <h2 class="mt-3">Auth</h2>
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th width="15%">Method</th>
                        <th width="25%">Route</th>
                        <th width="30%">Description</th>
                        <th width="30%">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/login">/api/login</a></td>
                        <td>Login and get token</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/register">/api/register</a></td>
                        <td>Register</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/logout">/api/logout</a></td>
                        <td>Logout</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/users">/api/users</a></td>
                        <td>Get detail user</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/refresh-token">/api/refresh-token</a></td>
                        <td>Refresh token</td>
                        <td>Not option</td>
                    </tr>
                </tbody>
            </table>

            <h2 class="mt-3">Categories</h2>
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th width="15%">Method</th>
                        <th width="25%">Route</th>
                        <th width="30%">Description</th>
                        <th width="30%">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/categories">/api/categories</a></td>
                        <td>Get all categories</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/categories/1">/api/categories/1</a></td>
                        <td>Get single categories</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/categories">/api/categories</a></td>
                        <td>Add a category</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/categories/1">/api/categories/1</a></td>
                        <td>Update a category</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/categories/delete/1">/api/categories/delete/1</a></td>
                        <td>Delete a category</td>
                        <td>Not option</td>
                    </tr>
                </tbody>
            </table>
            <h2 class="mt-3">Posts</h2>
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th width="15%">Method</th>
                        <th width="25%">Route</th>
                        <th width="30%">Description</th>
                        <th width="30%">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/posts">/api/posts</a></td>
                        <td>Get all posts</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/posts/1">/api/posts/1</a></td>
                        <td>Get single posts</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/posts/1/comments">/api/posts/1/comments</a></td>
                        <td>Get post's comments</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/posts?keyword=post">/api/posts?keyword=post</a></td>
                        <td>Search posts</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/posts?limit=10&offset=0">/api/posts?limit=10&offset=0</a></td>
                        <td>Limit & offset posts</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/posts/user/1">/api/posts/user/1</a></td>
                        <td>Get post by user id</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/posts">/api/posts</a></td>
                        <td>Create a new posts</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/posts/1">/api/posts/1</a></td>
                        <td>Update a post</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/posts/delete/1">/api/posts/delete/1</a></td>
                        <td>Delete a post</td>
                        <td>Not option</td>
                    </tr>
                </tbody>
            </table>
            <h2 class="mt-3">Comments and Sub comments</h2>
            <table class="table table-striped ">
                <thead>
                    <tr>
                        <th width="15%">Method</th>
                        <th width="25%">Route</th>
                        <th width="30%">Description</th>
                        <th width="30%">Option</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/comments">/api/comments</a></td>
                        <td>Get all comments</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/comments/1">/api/comments/1</a></td>
                        <td>Get single comments</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>GET</td>
                        <td><a href="/api/post/1/">/api/post/1</a></td>
                        <td>Get comments by post</td>
                        <td>Not option</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/comments">/api/comments</a></td>
                        <td>Create a new comments</td>
                        <td>comment_parent = 0 insert to comments, comment_parent != 0 insert to sub comment</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/comments/1">/api/comments/1</a></td>
                        <td>Update a comments</td>
                        <td>comment_parent = 0 update to comments, comment_parent != 0 update to sub comment</td>
                    </tr>
                    <tr>
                        <td>POST</td>
                        <td><a href="/api/comments/delete/1">/api/comments/delete/1</a></td>
                        <td>Delete a comment</td>
                        <td>comment_parent = 0 delete to comments, comment_parent != 0 delete to sub comment</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
