from pathlib import Path

blade = Path('resources/views/user/dashboard.blade.php')
lines = blade.read_text(encoding='utf-8').splitlines(keepends=True)
css = ''.join(lines[2:1224])
Path('public/css/dashboard.css').write_text(css, encoding='utf-8')
replacement = (
    lines[0:1]
    + [
        "    @push('styles')\n",
        '    <link rel="stylesheet" href="{{ asset(\'css/dashboard.css\') }}">\n',
        "@endpush\n",
        "\n",
    ]
    + lines[1225:]
)
blade.write_text(''.join(replacement), encoding='utf-8')
print('done')
