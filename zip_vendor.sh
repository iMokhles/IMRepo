FILE=vendor.zip
if test -f "$FILE"; then
    rm vendor.zip
fi
zip -r vendor.zip vendor
