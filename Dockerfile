# Dockerfile - 単一環境
FROM php:8.1-apache

# Composerインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 必要なツール
RUN apt-get update && apt-get install -y git unzip && apt-get clean

# ファイルコピー
COPY . /var/www/html/

# 作業ディレクトリ
WORKDIR /var/www/html

# 権限設定
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Composerインストール
RUN composer install --optimize-autoloader

EXPOSE 80
CMD ["apache2-foreground"]