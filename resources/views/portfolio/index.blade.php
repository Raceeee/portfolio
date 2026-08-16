<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $profile->full_name ?? 'Case File' }} — Case File</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500;600;700&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
        <button class="tab" role="tab" aria-selected="false" aria-controls="panel-skills" data-target="skills">
          <span class="tab-index">02</span> Skills
        </button>
        <button class="tab" role="tab" aria-selected="false" aria-controls="panel-experience" data-target="experience">
          <span class="tab-index">03</span> Experience
        </button>
        <button class="tab" role="tab" aria-selected="false" aria-controls="panel-projects" data-target="projects">
          <span class="tab-index">04</span> Projects
        </button>
        <button class="tab" role="tab" aria-selected="false" aria-controls="panel-contact" data-target="contact">
          <span class="tab-index">05</span> Contact
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
              <h1 class="subject-name">{{ $profile->full_name ?? 'Your Name' }}</h1>
              @if($profile->role_title)
                <p class="subject-role">{{ $profile->role_title }}</p>
              @endif

              <div class="meta-row">
                @if($profile->location)
                  <div class="meta-item"><span class="meta-k">Location</span><span class="meta-v">{{ $profile->location }}</span></div>
                @endif
                @if($profile->phone)
                  <div class="meta-item"><span class="meta-k">Phone</span><span class="meta-v">{{ $profile->phone }}</span></div>
                @endif
                @if($profile->email)
                  <div class="meta-item"><span class="meta-k">Email</span><span class="meta-v">{{ $profile->email }}</span></div>
                @endif
              </div>

              @if($profile->objective)
                <div class="block">
                  <h2 class="block-title">Objective</h2>
                  <p>{{ $profile->objective }}</p>
                </div>
              @endif

              @if($educations->count())
                <div class="block">
                  <h2 class="block-title">Education</h2>
                  @foreach ($educations as $education)
                    <div class="record">
                      <div class="record-top">
                        <span class="record-title">{{ $education->title }}</span>
                        @if($education->date_range)
                          <span class="record-date">{{ $education->date_range }}</span>
                        @endif
                      </div>
                      @if($education->institution)
                        <span class="record-sub">{{ $education->institution }}</span>
                      @endif
                    </div>
                  @endforeach
                </div>
              @endif
            </div>
          </section>

          <!-- SKILLS -->
          <section class="panel" id="panel-skills" role="tabpanel" hidden>
            <div class="panel-scroll">
              <h1 class="panel-heading">Skills</h1>

              @php
                $skillGroups = [
                  'language' => 'Programming Languages',
                  'core'     => 'Core Areas',
                  'tool'     => 'Tools & Platforms',
                  'soft'     => 'Soft Skills',
                ];
              @endphp

              @foreach ($skillGroups as $key => $label)
                @php($group = $skills->get($key))
                @if($group && $group->count())
                  <div class="block">
                    <h2 class="block-title">{{ $label }}</h2>
                    <div class="chip-row">
                      @foreach ($group as $skill)
                        <span class="chip {{ $key === 'soft' ? 'chip-outline' : '' }}">{{ $skill->name }}</span>
                      @endforeach
                    </div>
                  </div>
                @endif
              @endforeach
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
          <span>CLEARANCE: PUBLIC</span>
        </footer>

      </div>
    </div>
  </div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
