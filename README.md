# YSITD_QA_API
Write By Sciuridae and Coin
# API
GET question?token&user
Return 題目(string), 答案(array), 問題編號(int?), 出題者

POST answer
Fields: user, token, question_id, (correct or not)

GET user_info?user&
Retuen 答對題數 錯誤題數

POST start
Fields: token, user
建立基本使用者資料

# 使用
1. php init.php
建立資料庫用
2. vim config.php
將裡面的數值修改為主機的數值
3. 可以開始使用了!
