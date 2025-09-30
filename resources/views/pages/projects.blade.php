@extends('layouts.portfolio')

@section('title', 'Projects - M. Arief Asyraf')

@section('content')
    <!-- Mobile Navigation Menu Overlay -->
    <div class="nav-mobile" id="nav-mobile">
        <div class="mobile-overlay-container">
            <!-- Top Section: Theme Toggle and Close Button -->
            <div class="mobile-overlay-top">
                <!-- Theme Toggle (Left - aligned with logo) -->
                <button id="theme-toggle-overlay" class="theme-toggle">
                    <img src="{{ asset('assets/images/light-mode.png') }}" alt="Toggle theme" class="theme-toggle-icon w-6 h-6">
                </button>

                <!-- Close Button (Right - aligned with hamburger menu) -->
                <button class="mobile-menu-toggle active" id="mobile-menu-close">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>

            <!-- Center Section: Navigation Links -->
            <div class="mobile-overlay-center">
                <div class="mobile-overlay-links">
                    <a href="{{ route('home') }}" class="mobile-nav-link">HOME</a>
                    <a href="{{ route('about') }}" class="mobile-nav-link">ABOUT</a>
                    <a href="{{ route('projects') }}" class="mobile-nav-link">PROJECTS</a>
                    <a href="{{ route('contact') }}" class="mobile-nav-link">CONTACT</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="pt-32">
        <!-- Projects Section -->
        <section class="max-w-6xl mx-auto px-8 py-12 container-padding">
            <!-- Page Title -->
            <h1 class="section-title text-5xl font-bold mb-16 text-center-mobile">Projects.</h1>

            <!-- Projects Grid -->
            <div class="grid-projects grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                @if(isset($projects) && $projects->count() > 0)
                    @foreach($projects as $project)
                        <div class="group cursor-pointer" onclick="openProjectModal('project{{ $project->id }}')">
                            <div class="project-card bg-gray-800 rounded-lg overflow-hidden transition-transform duration-300 group-hover:scale-105">
                                @if($project->primaryImage)
                                    <div class="relative h-64 bg-gray-900">
                                        <img
                                            src="{{ asset('storage/' . $project->primaryImage->image_path) }}"
                                            alt="{{ $project->title }}"
                                            class="w-full h-full object-cover"
                                            loading="lazy"
                                        >
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                                        <div class="absolute bottom-0 left-0 right-0 p-6 text-center">
                                            <h3 class="text-white font-semibold text-lg mb-2 drop-shadow-lg">{{ $project->title }}</h3>
                                            <p class="text-gray-100 text-sm drop-shadow">{{ Str::limit($project->short_description, 80) }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="h-64 bg-gradient-to-br from-green-400 to-blue-500 flex items-center justify-center">
                                        <div class="text-center">
                                            <div class="w-16 h-16 bg-white/20 rounded-lg mx-auto mb-4 flex items-center justify-center">
                                                <i class="fas fa-project-diagram text-2xl text-white"></i>
                                            </div>
                                            <h3 class="text-white font-semibold text-lg mb-2">{{ $project->title }}</h3>
                                            <p class="text-gray-100 text-sm px-4">{{ Str::limit($project->short_description, 80) }}</p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Empty State -->
                    <div class="col-span-full text-center py-16">
                        <div class="text-center">
                            <i class="fas fa-folder-open text-6xl mb-4" style="color: var(--text-tertiary);"></i>
                            <h3 class="text-xl font-semibold mb-2" style="color: var(--text-primary);">No Projects Yet</h3>
                            <p class="text-gray-500 mb-6">Projects added through the admin panel will appear here.</p>
                            @auth
                                <a href="{{ route('admin.projects.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-300">
                                    <i class="fas fa-plus mr-2"></i>
                                    Add Your First Project
                                </a>
                            @endauth
                        </div>
                    </div>
                @endif
            </div>

        </section>
    </div>

    <!-- Footer -->
    <footer class="max-w-6xl mx-auto px-8 py-12 container-padding">
        <!-- Social Links -->
        <div class="footer-social flex items-center space-x-6">
            @if(isset($socialLinks) && $socialLinks->count() > 0)
                @foreach($socialLinks->where('is_active', true) as $social)
                    <a href="{{ $social->url }}" class="text-tertiary hover:text-primary transition-colors duration-300" target="_blank" rel="noopener noreferrer">
                        <i class="{{ $social->icon_class }} text-2xl"></i>
                    </a>
                @endforeach
            @endif
        </div>
    </footer>

    <!-- Project Modal -->
    <div id="projectModal" class="project-modal">
        <!-- Left Side - Blurred Background -->
        <div class="modal-backdrop" onclick="closeProjectModal()"></div>

        <!-- Right Side - Modal Content -->
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button class="modal-close-btn" onclick="closeProjectModal()" style="width: 44px !important; height: 44px !important; min-width: 44px !important; min-height: 44px !important; background: #000000 !important; border: 2px solid #000000 !important; border-radius: 50% !important; display: flex !important; align-items: center !important; justify-content: center !important; cursor: pointer !important; padding: 0 !important; flex-shrink: 0 !important;">
                    <span style="color: #FFFFFF; font-size: 24px; font-weight: bold; line-height: 1;">×</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Project Title -->
                <h2 class="project-title" id="modalProjectTitle">Project Title</h2>

                <!-- Project Description -->
                <p class="project-description" id="modalProjectDescription">Project description goes here.</p>

                <!-- Project Image -->
                <div class="project-image" id="modalProjectImage">
                    <div class="project-preview">
                        <div class="preview-content" id="modalProjectPreview">
                            <!-- Dynamic preview content -->
                        </div>
                    </div>
                </div>

                <!-- About Section -->
                <div class="modal-section">
                    <h3 class="section-title">About</h3>
                    <p class="section-content" id="modalProjectAbout">Detailed project information.</p>
                </div>

                <!-- Technologies Section -->
                <div class="modal-section">
                    <h3 class="section-title">Technologies</h3>
                    <div class="tech-tags" id="modalProjectTech">
                        <!-- Technology tags will be populated dynamically -->
                    </div>
                </div>

                <!-- Website Link -->
                <div class="modal-section" id="modalWebsiteSection">
                    <div class="link-section">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm0 14.4c-3.5 0-6.4-2.9-6.4-6.4S4.5 1.6 8 1.6s6.4 2.9 6.4 6.4-2.9 6.4-6.4 6.4z" fill="currentColor"/>
                        </svg>
                        <span class="link-title">Website</span>
                    </div>
                    <a class="project-link" id="modalProjectWebsite" href="#" target="_blank">Project website URL</a>
                </div>

                <!-- GitHub Link -->
                <div class="modal-section" id="modalGithubSection">
                    <div class="link-section">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0016 8c0-4.42-3.58-8-8-8z" fill="currentColor"/>
                        </svg>
                        <span class="link-title">Github</span>
                    </div>
                    <a class="project-link" id="modalProjectGithub" href="#" target="_blank">GitHub repository URL</a>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button class="open-project-btn" id="modalOpenProject">
                    Open Project
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <script>
        // Project data for modal functionality
        const projectsData = {
            @if(isset($projects) && $projects->count() > 0)
                @foreach($projects as $project)
                    'project{{ $project->id }}': {
                        id: {{ $project->id }},
                        title: @json($project->title),
                        shortDescription: @json($project->short_description),
                        detailedDescription: @json($project->detailed_description),
                        projectUrl: @json($project->project_url),
                        githubUrl: @json($project->github_url),
                        technologies: [
                            @foreach($project->technologies as $tech)
                                @json($tech->technology_name)@if(!$loop->last),@endif
                            @endforeach
                        ],
                        primaryImage: @json($project->primaryImage ? asset('storage/' . $project->primaryImage->image_path) : null),
                        images: [
                            @foreach($project->images as $image)
                                @json(asset('storage/' . $image->image_path))@if(!$loop->last),@endif
                            @endforeach
                        ]
                    }@if(!$loop->last),@endif
                @endforeach
            @endif
        };

        function openProjectModal(projectId) {
            const modal = document.getElementById('projectModal');
            const project = projectsData[projectId];

            if (!project) {
                console.error('Project not found:', projectId);
                return;
            }

            // Update modal content with project data
            document.getElementById('modalProjectTitle').textContent = project.title || 'Untitled Project';
            document.getElementById('modalProjectDescription').textContent = project.shortDescription || 'No description available.';
            document.getElementById('modalProjectAbout').textContent = project.detailedDescription || 'No detailed description available.';

            // Update project image/preview
            const modalPreview = document.getElementById('modalProjectPreview');
            if (project.primaryImage) {
                modalPreview.innerHTML = `<img src="${project.primaryImage}" alt="${project.title}" class="w-full h-full object-cover rounded-lg" style="max-height: 300px;">`;
            } else {
                modalPreview.innerHTML = `<div class="w-full h-64 bg-gradient-to-br from-green-400 to-blue-500 rounded-lg flex items-center justify-center">
                    <div class="text-center text-white">
                        <div class="w-16 h-16 bg-white/20 rounded-lg mx-auto mb-4 flex items-center justify-center">
                            <i class="fas fa-project-diagram text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-semibold">${project.title}</h3>
                    </div>
                </div>`;
            }

            // Update technologies
            const techContainer = document.getElementById('modalProjectTech');
            techContainer.innerHTML = '';
            if (project.technologies && project.technologies.length > 0) {
                project.technologies.forEach(tech => {
                    if (tech && tech.trim()) {
                        const techTag = document.createElement('span');
                        techTag.className = 'inline-block px-3 py-1 rounded-full text-sm mr-2 mb-2 transition-colors duration-300';
                        techTag.style.backgroundColor = 'var(--admin-bg-secondary)';
                        techTag.style.color = 'var(--admin-text-primary)';
                        techTag.style.border = '1px solid var(--admin-border-primary)';
                        techTag.textContent = tech;
                        techContainer.appendChild(techTag);
                    }
                });
            } else {
                techContainer.innerHTML = '<span class="text-gray-500 text-sm">No technologies listed</span>';
            }

            // Update links
            const websiteSection = document.getElementById('modalWebsiteSection');
            const githubSection = document.getElementById('modalGithubSection');
            const websiteLink = document.getElementById('modalProjectWebsite');
            const githubLink = document.getElementById('modalProjectGithub');
            const openProjectBtn = document.getElementById('modalOpenProject');

            // Website section
            if (project.projectUrl && project.projectUrl.trim()) {
                websiteSection.style.display = 'block';
                websiteLink.href = project.projectUrl;
                websiteLink.textContent = project.projectUrl;
                openProjectBtn.style.display = 'flex';
                openProjectBtn.onclick = () => window.open(project.projectUrl, '_blank', 'noopener,noreferrer');
            } else {
                websiteSection.style.display = 'none';
                openProjectBtn.style.display = 'none';
            }

            // GitHub section
            if (project.githubUrl && project.githubUrl.trim()) {
                githubSection.style.display = 'block';
                githubLink.href = project.githubUrl;
                githubLink.textContent = project.githubUrl;
            } else {
                githubSection.style.display = 'none';
            }

            // Show modal
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeProjectModal() {
            const modal = document.getElementById('projectModal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Close modal when clicking backdrop
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('modal-backdrop')) {
                closeProjectModal();
            }
        });

        // Close modal with escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('projectModal');
                if (modal.classList.contains('active')) {
                    closeProjectModal();
                }
            }
        });

        // Debug: Log available projects
        console.log('Available projects for modal:', Object.keys(projectsData));
    </script>
@endsection