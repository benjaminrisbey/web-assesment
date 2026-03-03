# start Live-Server and Browser-Sync

php -S 127.0.0.1:8000 > /dev/null 2>&1 &
browser-sync start --proxy "<http://127.0.0.1:8000>" --files "**/\*.php,**/_.css,\*\*/_.js"

# kill Live-Server and Browser-Sync

pkill -f "php -S"
pkill -f browser-sync
# web-assesment
