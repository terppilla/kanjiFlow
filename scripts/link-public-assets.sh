#!/usr/bin/env bash
# Create symlinks so /css, /img, /js are served from project root without hitting Laravel.
# Run on the server from project root: bash scripts/link-public-assets.sh

set -euo pipefail

ROOT="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT"

link_dir() {
    local name="$1"
    if [[ -L "$name" ]]; then
        echo "OK: $name already linked to $(readlink "$name")"
        return
    fi
    if [[ -e "$name" ]]; then
        echo "ERROR: '$name' exists and is not a symlink." >&2
        echo "       Remove or rename it (old hosting copy), then run this script again." >&2
        exit 1
    fi
    ln -sfn "public/$name" "$name"
    echo "Linked: $name -> public/$name"
}

link_dir css
link_dir js
link_dir img

if [[ -f public/favicon.ico ]] && [[ ! -e favicon.ico ]]; then
    ln -sfn public/favicon.ico favicon.ico
    echo "Linked: favicon.ico -> public/favicon.ico"
fi

echo "Done. Fix permissions if needed:"
echo "  find public -type d -exec chmod 755 {} \\;"
echo "  find public -type f -exec chmod 644 {} \\;"
