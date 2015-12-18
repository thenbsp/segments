# Symfony2 Blog Plain

### Frontend：

Method|Path|Route Name|Description
:---|:---|:---|:---
GET|/|app_homepage|博客首页
GET|/post/{postid}|app_post_show|查看指定文章
GET|/post/{postid}/comments|app_post_comments|查看指定文章的评论
POST|/post/{postid}/comments|app_post_comments_new|向指定文章发布评论
POST|/post/{postid}/comments/{commentid}/replies|app_post_comments_replies_new|向指定评论发布回复
GET|/categories|app_category|全部分类
GET|/categories/{categoryid}|app_category_posts|查看指定分类下的文章
GET|/users|app_user|全部作者
GET|/users/{username}|app_user_posts|查看指定作者下的文章
GET|/archives|app_archive|全部归档
GET|/archives/{year}/{month}/{day}|app_archive_posts|查看指定归档下的文章

### Backend：

Method|Path|Route Name|Description
:---|:---|:---|:---
GET|/admin|admin_homepage|欢迎页（仪表盘）
GET|/admin/posts|admin_posts|文章列表
GET/POST|/admin/posts/new|admin_posts_new|发布文章
GET/PUT|/admin/posts/{postid}|admin_posts_edit|编辑指定文章
DELETE|/admin/posts/{postids}|admin_posts_delete|删除指定文章
GET|/admin/comments|admin_comments|评论列表
GET/PUT|/admin/comments/{commentid}|admin_comments_edit|编辑评论
DELETE|/admin/comments/{commentids}|admin_comment_delete|删除评论
GET|/admin/categories|admin_categories|分类列表
GET/POST|/admin/categories/new|admin_categories_new |添加分类
GET/PUT|/admin/categories/{categoryid}|admin_categories_edit|编辑分类
DELETE|/admin/categories/{categoryid}|admin_categories_delete|删除分类
GET|/admin/users|admin_users|用户列表
GET/PUT|/admin/users/{userid}|admin_users_edit|编辑用户
DELETE|/admin/users/{userid}|admin_users_delete|删除用户
GET|/admin/files|admim_files|文件列表
POST|/admin/files/upload|admin_files_upload|上传文件
DELETE|/admin/files/{fileid}|admin_files_delete|删除文件
GET/PUT|/admin/settings|admin_settings|设置
