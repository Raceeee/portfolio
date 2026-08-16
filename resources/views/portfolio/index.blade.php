<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $profile->full_name ?? 'Case File' }} — Case File</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}?v={{ @filemtime(public_path('css/style.css')) }}">
</head>
<body>

  <!-- Intro reveal: sealed file opening to the case -->
  <div class="intro-overlay" id="introOverlay" aria-hidden="true" title="Click to skip">
    <div class="intro-mark">
      <span class="intro-tag">DECLASSIFYING</span>
      <span class="intro-title">CASE FILE</span>
      <span class="intro-bar"><span class="intro-bar-fill"></span></span>
    </div>
  </div>

  <div class="desk">

    <!-- Ambient background field, populated by script.js -->
    <div class="bg-field" id="bgField" aria-hidden="true"></div>

    <!-- Signature stamp element -->
    <div class="stamp" aria-hidden="true">
      <span>OPEN TO<br>WORK</span>
    </div>

    <div class="case">

      <!-- Folder tabs -->
      <nav class="tabs" role="tablist" aria-label="Case file sections">
        <button class="tab active" role="tab" aria-selected="true" aria-controls="panel-profile" data-target="profile">
          <span class="tab-index">01</span> Profile
        </button>
        <button class="tab" role="tab" aria-selected="false" aria-controls="panel-experience" data-target="experience">
          <span class="tab-index">02</span> Experience
        </button>
        <button class="tab" role="tab" aria-selected="false" aria-controls="panel-projects" data-target="projects">
          <span class="tab-index">03</span> Projects
        </button>
        <button class="tab" role="tab" aria-selected="false" aria-controls="panel-contact" data-target="contact">
          <span class="tab-index">04</span> Contact
        </button>
      </nav>

      <!-- Folder body -->
      <div class="folder-body">

        <header class="case-header">
          <div class="case-header-left">
            <span class="case-label">CASE FILE</span>
            <span class="case-number">NO. {{ $profile->case_number ?? '—' }}</span>
          </div>
          <div class="case-header-right">
            <span class="status-dot"></span> STATUS: {{ $profile->status ?? 'ACTIVE' }}
          </div>
        </header>

        <div class="panels">

          <!-- PROFILE -->
          <section class="panel active" id="panel-profile" role="tabpanel">
            <div class="panel-scroll">
              <div class="profile-hero">
                <h1 class="subject-name">{{ $profile->full_name ?? 'Your Name' }}</h1>
                @if($profile->role_title)
                  <p class="subject-role">{{ $profile->role_title }}</p>
                @endif

                @php
                  $aboutParagraphs = collect(preg_split('/\n\s*\n/', trim($profile->objective ?? '')))->filter()->values();
                @endphp

                @if($aboutParagraphs->isNotEmpty())
                  <div class="block about-block">
                    <h2 class="block-title">About Me</h2>
                    @foreach ($aboutParagraphs as $index => $paragraph)
                      <p class="{{ $index === $aboutParagraphs->count() - 1 ? 'about-highlight' : '' }}">{{ $paragraph }}</p>
                    @endforeach
                  </div>
                @endif

                @php
                  $topSkills = collect()
                    ->merge($skills->get('language', collect()))
                    ->merge($skills->get('core', collect()))
                    ->merge($skills->get('tool', collect()))
                    ->take(10);
                @endphp

                @if($topSkills->isNotEmpty())
                  <div class="chip-row profile-chip-row">
                    @foreach ($topSkills as $skill)
                      <span class="chip">{{ $skill->name }}</span>
                    @endforeach
                  </div>
                @endif

                @if($profile->github_url || $profile->linkedin_url || $profile->email)
                  <div class="profile-social">
                    @if($profile->github_url)
                      <a href="{{ $profile->github_url }}" target="_blank" rel="noopener" class="social-btn" aria-label="GitHub">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.39 7.86 10.91.57.1.78-.25.78-.55v-1.94c-3.2.7-3.87-1.36-3.87-1.36-.53-1.33-1.29-1.69-1.29-1.69-1.05-.72.08-.7.08-.7 1.16.08 1.77 1.19 1.77 1.19 1.03 1.77 2.71 1.26 3.37.96.1-.75.4-1.26.73-1.55-2.55-.29-5.24-1.28-5.24-5.68 0-1.26.45-2.28 1.19-3.09-.12-.29-.52-1.46.11-3.04 0 0 .97-.31 3.18 1.18a11 11 0 0 1 5.79 0c2.2-1.49 3.17-1.18 3.17-1.18.63 1.58.23 2.75.12 3.04.74.81 1.18 1.83 1.18 3.09 0 4.41-2.69 5.38-5.25 5.67.41.36.78 1.06.78 2.15v3.19c0 .3.21.66.79.55A10.51 10.51 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5Z"/></svg>
                      </a>
                    @endif
                    @if($profile->linkedin_url)
                      <a href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener" class="social-btn" aria-label="LinkedIn">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M20.45 20.45h-3.56v-5.57c0-1.33-.02-3.04-1.85-3.04-1.86 0-2.14 1.45-2.14 2.94v5.67H9.34V9h3.42v1.56h.05c.48-.9 1.64-1.85 3.38-1.85 3.6 0 4.27 2.37 4.27 5.46v6.28ZM5.34 7.43a2.07 2.07 0 1 1 0-4.13 2.07 2.07 0 0 1 0 4.13ZM7.12 20.45H3.56V9h3.56v11.45Z"/></svg>
                      </a>
                    @endif
                    @if($profile->email)
                      <a href="mailto:{{ $profile->email }}" class="social-btn" aria-label="Email">
                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="2.5" y="4.5" width="19" height="15" rx="2"/><path d="m3 6 9 7 9-7"/></svg>
                      </a>
                    @endif
                  </div>
                @endif
              </div>
            </div>
          </section>

          <!-- EXPERIENCE -->
          <section class="panel" id="panel-experience" role="tabpanel" hidden>
            <div class="panel-scroll">
              <h1 class="panel-heading">Work Experience</h1>

              @forelse ($experiences as $experience)
                <div class="log">
                  <div class="log-top">
                    <span class="log-title">{{ $experience->title }}</span>
                    @if($experience->date_range)
                      <span class="log-date">{{ $experience->date_range }}</span>
                    @endif
                  </div>
                  @if($experience->organization)
                    <span class="log-org">{{ $experience->organization }}</span>
                  @endif
                  @if(!empty($experience->bullets))
                    <ul>
                      @foreach ($experience->bullets as $bullet)
                        <li>{{ $bullet }}</li>
                      @endforeach
                    </ul>
                  @endif
                </div>
              @empty
                <p class="edit-note">No experience entries yet — add some from the admin panel.</p>
              @endforelse
            </div>
          </section>

          <!-- PROJECTS -->
          <section class="panel" id="panel-projects" role="tabpanel" hidden>
            <div class="panel-scroll">
              <h1 class="panel-heading">Projects &amp; Academic Work</h1>

              @forelse ($projects as $project)
                <div class="project-card">
                  @if($project->tag)
                    <span class="project-tag">{{ $project->tag }}</span>
                  @endif
                  <h2 class="project-title">{{ $project->title }}</h2>
                  @if($project->subtitle)
                    <p class="project-sub">{{ $project->subtitle }}</p>
                  @endif
                  @if($project->description)
                    <p>{{ $project->description }}</p>
                  @endif
                </div>
              @empty
                <p class="edit-note">No projects yet — add some from the admin panel.</p>
              @endforelse
            </div>
          </section>

          <!-- CONTACT -->
          <section class="panel" id="panel-contact" role="tabpanel" hidden>
            <div class="panel-scroll">
              <h1 class="panel-heading">Contact</h1>
              <p class="contact-intro">Open to IT, systems development, and cybersecurity-related opportunities.</p>

              <div class="contact-list">
                @if($profile->email)
                  <a class="contact-row" href="mailto:{{ $profile->email }}">
                    <span class="contact-k">Email</span>
                    <span class="contact-v">{{ $profile->email }}</span>
                  </a>
                @endif
                @if($profile->phone)
                  <div class="contact-row">
                    <span class="contact-k">Phone</span>
                    <span class="contact-v">{{ $profile->phone }}</span>
                  </div>
                @endif
                @if($profile->location)
                  <div class="contact-row">
                    <span class="contact-k">Location</span>
                    <span class="contact-v">{{ $profile->location }}</span>
                  </div>
                @endif
                @if($profile->github_url)
                  <a class="contact-row" href="{{ $profile->github_url }}" target="_blank" rel="noopener">
                    <span class="contact-k">GitHub</span>
                    <span class="contact-v">{{ $profile->github_url }}</span>
                  </a>
                @endif
                @if($profile->linkedin_url)
                  <a class="contact-row" href="{{ $profile->linkedin_url }}" target="_blank" rel="noopener">
                    <span class="contact-k">LinkedIn</span>
                    <span class="contact-v">{{ $profile->linkedin_url }}</span>
                  </a>
                @endif
              </div>
            </div>
          </section>

        </div>

        <footer class="case-footer">
          <span>FIELD: SOFTWARE / SYSTEMS / SECURITY</span>
          <span class="footer-mid">USE ARROW KEYS OR CLICK TABS TO NAVIGATE</span>
          <span class="case-footer-right">
            <span>CLEARANCE: PUBLIC</span>
            <a href="{{ route('login') }}" class="admin-link">Admin Login</a>
          </span>
        </footer>

      </div>
    </div>

  </div>

<script src="{{ asset('js/script.js') }}?v={{ @filemtime(public_path('js/script.js')) }}"></script>
</body>
</html>