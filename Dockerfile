# ベースイメージとしてPHPの公式イメージを使用
FROM php:8.0-apache

# ソースコードをコンテナ内にコピー
COPY src/ /var/www/html/

# Apacheを前景で実行する
CMD ["apache2-foreground"]