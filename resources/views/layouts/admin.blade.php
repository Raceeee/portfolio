<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Admin') — Case File</title>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<style>
  :root {
    --desk:#0d120f; --folder:#1a201b; --rule:#2c342d; --ink:#e8e4d8;
    --ink-muted:#8b9188; --ink-faint:#565f58; --accent-green:#6fcf97; --accent-red:#c1443c;
    --font-mono:'IBM Plex Mono',monospace; --font-sans:'IBM Plex Sans',sans-serif;
  }
  * { box-sizing:border-box; }
  body { margin:0; background:var(--desk); color:var(--ink); font-family:var(--font-sans); min-height:100vh; }
  a { color:var(--accent-green); }
  header.admin-bar {
    display:flex; justify-content:space-between; align-items:center;
    padding:16px 28px; border-bottom:1px solid var(--rule); font-family:var(--font-mono);
  }
  header.admin-bar .brand { color:var(--accent-green); letter-spacing:0.08em; text-transform:uppercase; font-size:13px; }
  header.admin-bar nav a { margin-left:16px; font-size:13px; text-decoration:none; color:var(--ink-muted); }
  header.admin-bar nav a:hover, header.admin-bar nav a.active { color:var(--ink); }
  main { max-width:900px; margin:0 auto; padding:32px 20px 80px; }
  h1 { font-family:var(--font-mono); font-size:22px; margin:0 0 22px; }
  .card { background:var(--folder); border:1px solid var(--rule); border-radius:8px; padding:22px; margin-bottom:18px; }
  .status { background:rgba(111,207,151,0.1); border:1px solid rgba(111,207,151,0.35); color:var(--accent-green);
    padding:10px 14px; border-radius:6px; font-size:13px; margin-bottom:18px; font-family:var(--font-mono); }
  .errors { background:rgba(193,68,60,0.1); border:1px solid rgba(193,68,60,0.4); color:#e79a95;
    padding:10px 14px; border-radius:6px; font-size:13px; margin-bottom:18px; }
  .errors ul { margin:0; padding-left:18px; }
  label { display:block; font-family:var(--font-mono); font-size:11px; text-transform:uppercase; letter-spacing:0.06em;
    color:var(--ink-faint); margin:14px 0 6px; }
  input[type=text], input[type=email], input[type=password], input[type=number], input[type=url], textarea, select {
    width:100%; padding:10px 12px; background:#14181a; border:1px solid var(--rule); border-radius:6px;
    color:var(--ink); font-family:var(--font-sans); font-size:14px;
  }
  textarea { min-height:110px; resize:vertical; }
  .btn {
    display:inline-block; padding:10px 18px; border-radius:6px; border:1px solid var(--accent-green);
    background:transparent; color:var(--accent-green); font-family:var(--font-mono); font-size:13px;
    cursor:pointer; text-decoration:none; margin-top:16px;
  }
  .btn:hover { background:rgba(111,207,151,0.1); }
  .btn-danger { border-color:var(--accent-red); color:#e79a95; }
  .btn-danger:hover { background:rgba(193,68,60,0.1); }
  .list-row {
    display:flex; justify-content:space-between; align-items:center; gap:12px;
    padding:14px 4px; border-bottom:1px solid var(--rule);
  }
  .list-row:last-child { border-bottom:none; }
  .list-row .meta { font-size:12px; color:var(--ink-faint); font-family:var(--font-mono); }
  .list-row .actions a, .list-row .actions button {
    font-family:var(--font-mono); font-size:12px; margin-left:10px; background:none; border:none;
    color:var(--ink-muted); cursor:pointer; text-decoration:underline;
  }
  .list-row .actions button.danger { color:#e79a95; }
  .top-actions { display:flex; justify-content:space-between; align-items:center; margin-bottom:18px; }
  .dash-grid { display:grid; grid-template-columns:repeat(auto-fit, minmax(160px,1fr)); gap:14px; }
  .dash-card { background:var(--folder); border:1px solid var(--rule); border-radius:8px; padding:20px; text-decoration:none; color:var(--ink); }
  .dash-card .num { font-family:var(--font-mono); font-size:28px; color:var(--accent-green); }
  .dash-card .label { font-size:13px; color:var(--ink-muted); margin-top:4px; }
</style>
</head>
<body>

@auth
<header class="admin-bar">
  <span class="brand">Case File / Admin</span>
  <nav>
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <a href="{{ route('admin.profile.edit') }}">Profile</a>
    <a href="{{ route('admin.educations.index') }}">Education</a>
    <a href="{{ route('admin.skills.index') }}">Skills</a>
    <a href="{{ route('admin.experiences.index') }}">Experience</a>
    <a href="{{ route('admin.projects.index') }}">Projects</a>
    <a href="{{ route('portfolio') }}" target="_blank">View site ↗</a>
    <form action="{{ route('logout') }}" method="POST" style="display:inline">
      @csrf
      <button type="submit" style="background:none;border:none;color:var(--ink-muted);font-family:var(--font-mono);font-size:13px;cursor:pointer;margin-left:16px;">Log out</button>
    </form>
  </nav>
</header>
@endauth

<main>
  @if (session('status'))
    <div class="status">{{ session('status') }}</div>
  @endif

  @if ($errors->any())
    <div class="errors">
      <ul>
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @yield('content')
</main>

</body>
</html>
