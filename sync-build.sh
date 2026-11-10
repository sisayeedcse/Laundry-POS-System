#!/bin/bash
# deploy-build.ps1 / Run before git push to keep build/ in sync with public/build/

# Copy compiled assets to root build/ (needed by cPanel production server)
cp public/build/manifest.json build/manifest.json
cp -R public/build/assets/. build/assets/

echo "build/ synced from public/build/ — ready to git add and push"
