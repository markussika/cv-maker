<x-app-layout>
    <div class="relative isolate overflow-hidden bg-slate-950 text-white">
        <div class="pointer-events-none absolute -top-32 right-4 h-72 w-72 rounded-full bg-indigo-500/40 blur-3xl"></div>
        <div class="pointer-events-none absolute bottom-0 left-1/2 h-80 w-80 -translate-x-1/2 rounded-full bg-blue-400/30 blur-3xl"></div>

        <section class="relative mx-auto max-w-5xl px-6 py-20 text-center">
            <p class="inline-flex items-center gap-2 rounded-full bg-white/10 px-4 py-1 text-xs font-semibold uppercase tracking-[0.25em] text-indigo-200">
                <span class="h-2 w-2 rounded-full bg-indigo-400"></span>
                CV Mastery
            </p>
            <h1 class="mt-6 text-4xl font-semibold tracking-tight sm:text-5xl">Design a CV that tells your story beautifully</h1>
            <p class="mx-auto mt-6 max-w-3xl text-base leading-relaxed text-slate-200 sm:text-lg">
                A thoughtfully crafted CV is more than a list of roles — it is a curated narrative of your growth. Follow these curated guidelines to create a document that feels polished, modern, and uniquely yours, while still being easy for busy recruiters and applicant tracking systems to scan.
            </p>
            <div class="mt-10 flex flex-wrap justify-center gap-4">
                <a href="{{ route('cv.create') }}" class="inline-flex items-center gap-2 rounded-full bg-white px-6 py-3 text-sm font-semibold text-slate-900 shadow-lg shadow-indigo-500/20 transition hover:-translate-y-0.5 hover:shadow-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Start crafting your CV
                </a>
                <a href="#best-practices" class="inline-flex items-center gap-2 rounded-full border border-white/60 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                    Explore tips
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0-6.75 6.75M19.5 12l-6.75-6.75" />
                    </svg>
                </a>
            </div>
        </section>
    </div>

    <section id="best-practices" class="bg-slate-100">
        <div class="mx-auto max-w-5xl space-y-16 px-6 py-16">
            <div class="grid gap-8 md:grid-cols-3">
                <article class="group rounded-3xl border border-slate-200 bg-white p-8 shadow-lg shadow-slate-900/5 transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-500 to-blue-500 text-white shadow-lg shadow-indigo-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h7.5m-7.5 3.75h7.5M4.5 5.25A2.25 2.25 0 0 1 6.75 3h10.5A2.25 2.25 0 0 1 19.5 5.25v13.5L12 15.75 4.5 18.75z" />
                        </svg>
                    </div>
                    <h2 class="mt-6 text-xl font-semibold text-slate-900">Lead with clarity</h2>
                    <p class="mt-4 text-sm text-slate-600">
                        Keep your CV concise and purposeful. Stick to one or two pages, use clear section headers, and prioritize recent experience so your reader can understand your value in seconds.
                    </p>
                </article>

                <article class="group rounded-3xl border border-slate-200 bg-white p-8 shadow-lg shadow-slate-900/5 transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-500 to-indigo-500 text-white shadow-lg shadow-indigo-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 9.75 7.5 4.5v15l9-5.25" />
                        </svg>
                    </div>
                    <h2 class="mt-6 text-xl font-semibold text-slate-900">Showcase achievements</h2>
                    <p class="mt-4 text-sm text-slate-600">
                        Focus on measurable wins. Pair active verbs with data points, context, and outcomes so recruiters quickly see the scope of your impact.
                    </p>
                </article>

                <article class="group rounded-3xl border border-slate-200 bg-white p-8 shadow-lg shadow-slate-900/5 transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-cyan-500 to-blue-500 text-white shadow-lg shadow-cyan-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15l3.75-4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                        </svg>
                    </div>
                    <h2 class="mt-6 text-xl font-semibold text-slate-900">Polish the layout</h2>
                    <p class="mt-4 text-sm text-slate-600">
                        Embrace generous spacing, consistent fonts, and clear headings. A clean structure paired with balanced white space makes your CV effortless to read on screen and on paper.
                    </p>
                </article>
            </div>

            <div class="grid gap-8 lg:grid-cols-[1.1fr,0.9fr]">
                <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-lg shadow-slate-900/5">
                    <h2 class="text-2xl font-semibold text-slate-900">Essential sections to include</h2>
                    <p class="mt-4 text-sm text-slate-600">
                        Craft each section with intention. Use bullet points to surface the highlights, keep paragraphs short, and make sure every line answers “Why should they hire me?”
                    </p>
                    <div class="mt-6 space-y-6 text-sm text-slate-700">
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <h3 class="font-semibold text-slate-900">Contact &amp; headline</h3>
                            <p class="mt-2 text-slate-600">Include your name, role or brand statement, phone, professional email, LinkedIn, and portfolio links. Skip full addresses unless requested.</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <h3 class="font-semibold text-slate-900">Professional summary</h3>
                            <p class="mt-2 text-slate-600">Write 2–3 sentences highlighting your strengths, target role, and key achievements. Mirror language from the job description to show fit.</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <h3 class="font-semibold text-slate-900">Experience</h3>
                            <ul class="mt-2 space-y-2 text-slate-600">
                                <li>Start with your title, company, location, and dates (month + year).</li>
                                <li>Use bullet points that combine action + task + result. Aim for measurable outcomes.</li>
                                <li>Highlight promotions, cross-functional work, or leadership moments.</li>
                            </ul>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <h3 class="font-semibold text-slate-900">Skills &amp; tools</h3>
                            <p class="mt-2 text-slate-600">Group hard skills, software, and soft skills by theme. Prioritize the ones that are listed in the role requirements.</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <h3 class="font-semibold text-slate-900">Education &amp; credentials</h3>
                            <p class="mt-2 text-slate-600">List degrees, certifications, bootcamps, and notable coursework. Add honors, GPA, or thesis topics if they strengthen your story.</p>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-4">
                            <h3 class="font-semibold text-slate-900">Optional extras</h3>
                            <p class="mt-2 text-slate-600">Awards, publications, volunteer work, languages, and community leadership can signal well-roundedness—include them if they reinforce your positioning.</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col justify-between rounded-3xl border border-indigo-200 bg-gradient-to-br from-indigo-500 via-indigo-500 to-blue-500 p-8 text-white shadow-xl shadow-indigo-500/30">
                    <div>
                        <h2 class="text-2xl font-semibold">Finishing touches that stand out</h2>
                        <ul class="mt-6 space-y-4 text-sm text-indigo-50">
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mt-0.5 h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                                Tailor your summary and keywords for each role you apply to.
                            </li>
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mt-0.5 h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15l3.75-4.5m6-2.25a9 9 0 1 1-18 0 9 9 0 0 1 18 0z" />
                                </svg>
                                Proofread carefully; refined language leaves a lasting impression.
                            </li>
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mt-0.5 h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 3" />
                                </svg>
                                Keep formatting simple so applicant tracking systems (ATS) read it flawlessly.
                            </li>
                            <li class="flex items-start gap-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="mt-0.5 h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-3A2.25 2.25 0 0 0 8.25 5.25V9m-3 3h13.5m-10.5 0v6.75A2.25 2.25 0 0 0 10.5 21h3a2.25 2.25 0 0 0 2.25-2.25V12" />
                                </svg>
                                Export a tailored PDF for each application and keep an editable master copy for quick updates.
                            </li>
                        </ul>
                    </div>
                    <div class="mt-8 rounded-2xl bg-white/15 p-6 text-sm backdrop-blur">
                        <p class="font-semibold uppercase tracking-wide text-indigo-200">Quick tip</p>
                        <p class="mt-3 text-indigo-50">
                            Save your CV as a PDF to preserve layout and typography across devices, and name the file professionally (e.g., <em>firstname_lastname_cv.pdf</em>).
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid gap-8 lg:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-white p-10 shadow-lg shadow-slate-900/5">
                    <h2 class="text-2xl font-semibold text-slate-900">Make every line count</h2>
                    <ul class="mt-4 space-y-3 text-sm text-slate-600">
                        <li><span class="font-medium text-slate-900">Do:</span> Open with the strongest evidence of your fit for the role, even if it is a side project or contract.</li>
                        <li><span class="font-medium text-slate-900">Do:</span> Quantify impact with metrics (%, $, time saved) or qualitative proof (customer praise, awards).</li>
                        <li><span class="font-medium text-slate-900">Do:</span> Align tone and vocabulary with the industry—creative roles can flex with storytelling while technical roles should emphasize rigor.</li>
                        <li><span class="font-medium text-red-500">Avoid:</span> Dense paragraphs, personal pronouns, or outdated skills that distract from your current strengths.</li>
                        <li><span class="font-medium text-red-500">Avoid:</span> Sensitive personal data (age, marital status, photos) unless required by regional norms.</li>
                    </ul>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-10 text-center shadow-lg shadow-slate-900/5">
                    <h2 class="text-3xl font-semibold text-slate-900">Ready to shine?</h2>
                    <p class="mx-auto mt-4 max-w-2xl text-sm text-slate-600">
                        Start with these building blocks, then tailor the tone to match your personality and the industry you are targeting. A confident, well-structured CV makes it easy for recruiters to say yes.
                    </p>
                    <a href="{{ route('cv.create') }}" class="mt-8 inline-flex items-center gap-2 rounded-full bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-slate-900/30 transition hover:-translate-y-0.5 hover:bg-slate-800">
                        Launch the CV builder
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0-6.75 6.75M19.5 12l-6.75-6.75" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
