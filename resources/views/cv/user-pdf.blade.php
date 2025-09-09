<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CV PDF</title>
<style>
body { font-family: DejaVu Sans, sans-serif; color: #333; }
h1, h2, h3 { color: #111; }
.container { width: 100%; padding: 20px; }
.section { margin-bottom: 20px; }
.border { border: 1px solid #ccc; padding: 10px; border-radius: 5px; margin-bottom: 10px; }
ul { padding-left: 20px; }
</style>
</head>
<body>
    @include('cv.partials.user-pdf-layout', ['data' => $data])
</body>
</html>
