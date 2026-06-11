<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Laravel API Documentation</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.style.css") }}" media="screen">
    <link rel="stylesheet" href="{{ asset("/vendor/scribe/css/theme-default.print.css") }}" media="print">

    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.10/lodash.min.js"></script>

    <link rel="stylesheet"
          href="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/styles/obsidian.min.css">
    <script src="https://unpkg.com/@highlightjs/cdn-assets@11.6.0/highlight.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jets/0.14.1/jets.min.js"></script>

    <style id="language-style">
        /* starts out as display none and is replaced with js later  */
                    body .content .bash-example code { display: none; }
                    body .content .javascript-example code { display: none; }
            </style>

    <script>
        var tryItOutBaseUrl = "http://localhost";
        var useCsrf = Boolean();
        var csrfUrl = "/sanctum/csrf-cookie";
    </script>
    <script src="{{ asset("/vendor/scribe/js/tryitout-5.11.0.js") }}"></script>

    <script src="{{ asset("/vendor/scribe/js/theme-default-5.11.0.js") }}"></script>

</head>

<body data-languages="[&quot;bash&quot;,&quot;javascript&quot;]">

<a href="#" id="nav-button">
    <span>
        MENU
        <img src="{{ asset("/vendor/scribe/images/navbar.png") }}" alt="navbar-image"/>
    </span>
</a>
<div class="tocify-wrapper">
    
            <div class="lang-selector">
                                            <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                            <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                    </div>
    
    <div class="search">
        <input type="text" class="search" id="input-search" placeholder="Search">
    </div>

    <div id="toc">
                    <ul id="tocify-header-introduction" class="tocify-header">
                <li class="tocify-item level-1" data-unique="introduction">
                    <a href="#introduction">Introduction</a>
                </li>
                            </ul>
                    <ul id="tocify-header-authenticating-requests" class="tocify-header">
                <li class="tocify-item level-1" data-unique="authenticating-requests">
                    <a href="#authenticating-requests">Authenticating requests</a>
                </li>
                            </ul>
                    <ul id="tocify-header-achievements" class="tocify-header">
                <li class="tocify-item level-1" data-unique="achievements">
                    <a href="#achievements">Achievements</a>
                </li>
                                    <ul id="tocify-subheader-achievements" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="achievements-GETapi-v1-units--slug--achievements">
                                <a href="#achievements-GETapi-v1-units--slug--achievements">Get achievements.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-extracurriculars" class="tocify-header">
                <li class="tocify-item level-1" data-unique="extracurriculars">
                    <a href="#extracurriculars">Extracurriculars</a>
                </li>
                                    <ul id="tocify-subheader-extracurriculars" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="extracurriculars-GETapi-v1-units--slug--extracurriculars">
                                <a href="#extracurriculars-GETapi-v1-units--slug--extracurriculars">Get extracurriculars.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-galleries" class="tocify-header">
                <li class="tocify-item level-1" data-unique="galleries">
                    <a href="#galleries">Galleries</a>
                </li>
                                    <ul id="tocify-subheader-galleries" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="galleries-GETapi-v1-units--slug--galleries">
                                <a href="#galleries-GETapi-v1-units--slug--galleries">Get galleries.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="galleries-GETapi-v1-units--slug--galleries--id-">
                                <a href="#galleries-GETapi-v1-units--slug--galleries--id-">Get gallery details.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-majors" class="tocify-header">
                <li class="tocify-item level-1" data-unique="majors">
                    <a href="#majors">Majors</a>
                </li>
                                    <ul id="tocify-subheader-majors" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="majors-GETapi-v1-units--slug--majors">
                                <a href="#majors-GETapi-v1-units--slug--majors">Get majors list.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="majors-GETapi-v1-units--slug--majors--id-">
                                <a href="#majors-GETapi-v1-units--slug--majors--id-">Get major details.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-news" class="tocify-header">
                <li class="tocify-item level-1" data-unique="news">
                    <a href="#news">News</a>
                </li>
                                    <ul id="tocify-subheader-news" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="news-GETapi-v1-units--slug--news">
                                <a href="#news-GETapi-v1-units--slug--news">Get news listing.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="news-GETapi-v1-units--slug--news--newsSlug-">
                                <a href="#news-GETapi-v1-units--slug--news--newsSlug-">Get news detail.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-spmb" class="tocify-header">
                <li class="tocify-item level-1" data-unique="spmb">
                    <a href="#spmb">SPMB</a>
                </li>
                                    <ul id="tocify-subheader-spmb" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="spmb-GETapi-v1-units--slug--spmb">
                                <a href="#spmb-GETapi-v1-units--slug--spmb">Get SPMB settings.</a>
                            </li>
                                                                        </ul>
                            </ul>
                    <ul id="tocify-header-units" class="tocify-header">
                <li class="tocify-item level-1" data-unique="units">
                    <a href="#units">Units</a>
                </li>
                                    <ul id="tocify-subheader-units" class="tocify-subheader">
                                                    <li class="tocify-item level-2" data-unique="units-GETapi-v1-units">
                                <a href="#units-GETapi-v1-units">Get active units.</a>
                            </li>
                                                                                <li class="tocify-item level-2" data-unique="units-GETapi-v1-units--slug-">
                                <a href="#units-GETapi-v1-units--slug-">Get unit details.</a>
                            </li>
                                                                        </ul>
                            </ul>
            </div>

    <ul class="toc-footer" id="toc-footer">
                    <li style="padding-bottom: 5px;"><a href="{{ route("scribe.postman") }}">View Postman collection</a></li>
                            <li style="padding-bottom: 5px;"><a href="{{ route("scribe.openapi") }}">View OpenAPI spec</a></li>
                <li><a href="http://github.com/knuckleswtf/scribe">Documentation powered by Scribe ✍</a></li>
    </ul>

    <ul class="toc-footer" id="last-updated">
        <li>Last updated: June 11, 2026</li>
    </ul>
</div>

<div class="page-wrapper">
    <div class="dark-box"></div>
    <div class="content">
        <h1 id="introduction">Introduction</h1>
<aside>
    <strong>Base URL</strong>: <code>http://localhost</code>
</aside>
<pre><code>This documentation aims to provide all the information you need to work with our API.

&lt;aside&gt;As you scroll, you'll see code examples for working with the API in different programming languages in the dark area to the right (or as part of the content on mobile).
You can switch the language used with the tabs at the top right (or from the nav menu at the top left on mobile).&lt;/aside&gt;</code></pre>

        <h1 id="authenticating-requests">Authenticating requests</h1>
<p>This API is not authenticated.</p>

        <h1 id="achievements">Achievements</h1>

    <p>API for querying school achievements.</p>

                                <h2 id="achievements-GETapi-v1-units--slug--achievements">Get achievements.</h2>

<p>
</p>

<p>Returns a list of achievements for the specified school unit.</p>

<span id="example-requests-GETapi-v1-units--slug--achievements">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/v1/units/smk-mandiri/achievements?peraih=siswa" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/units/smk-mandiri/achievements"
);

const params = {
    "peraih": "siswa",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-units--slug--achievements">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Daftar prestasi berhasil diambil.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;judul_prestasi&quot;: &quot;Juara 1 Lomba LKS SMK&quot;,
            &quot;tahun_prestasi&quot;: 2026,
            &quot;peraih_prestasi&quot;: &quot;siswa&quot;,
            &quot;deskripsi_prestasi&quot;: &quot;Juara 1 Bidang IT Network Systems Administration.&quot;,
            &quot;foto_penghargaan&quot;: &quot;http://localhost/storage/1/ach.png&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-units--slug--achievements" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-units--slug--achievements"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-units--slug--achievements"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-units--slug--achievements" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-units--slug--achievements">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-units--slug--achievements" data-method="GET"
      data-path="api/v1/units/{slug}/achievements"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-units--slug--achievements', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-units--slug--achievements"
                    onclick="tryItOut('GETapi-v1-units--slug--achievements');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-units--slug--achievements"
                    onclick="cancelTryOut('GETapi-v1-units--slug--achievements');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-units--slug--achievements"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/units/{slug}/achievements</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-units--slug--achievements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-units--slug--achievements"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="GETapi-v1-units--slug--achievements"
               value="smk-mandiri"
               data-component="url">
    <br>
<p>The slug of the school unit. Example: <code>smk-mandiri</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>peraih</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="peraih"                data-endpoint="GETapi-v1-units--slug--achievements"
               value="siswa"
               data-component="query">
    <br>
<p>Filter achievements by recipient role: <code>siswa</code>, <code>guru</code>, <code>tendik</code>, or <code>sekolah</code>. Example: <code>siswa</code></p>
            </div>
                </form>

                <h1 id="extracurriculars">Extracurriculars</h1>

    <p>API for querying school extracurricular organizations and clubs.</p>

                                <h2 id="extracurriculars-GETapi-v1-units--slug--extracurriculars">Get extracurriculars.</h2>

<p>
</p>

<p>Returns a list of extracurriculars for the specified school unit.</p>

<span id="example-requests-GETapi-v1-units--slug--extracurriculars">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/v1/units/smk-mandiri/extracurriculars" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/units/smk-mandiri/extracurriculars"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-units--slug--extracurriculars">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Daftar ekstrakurikuler berhasil diambil.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;nama_ekskul&quot;: &quot;Pramuka&quot;,
            &quot;pembina_ekskul&quot;: &quot;Kak Ahmad&quot;,
            &quot;jadwal_kegiatan&quot;: &quot;Sabtu 08:00 - 11:00&quot;,
            &quot;logo_ekskul&quot;: &quot;http://localhost/storage/1/ekskul.png&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-units--slug--extracurriculars" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-units--slug--extracurriculars"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-units--slug--extracurriculars"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-units--slug--extracurriculars" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-units--slug--extracurriculars">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-units--slug--extracurriculars" data-method="GET"
      data-path="api/v1/units/{slug}/extracurriculars"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-units--slug--extracurriculars', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-units--slug--extracurriculars"
                    onclick="tryItOut('GETapi-v1-units--slug--extracurriculars');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-units--slug--extracurriculars"
                    onclick="cancelTryOut('GETapi-v1-units--slug--extracurriculars');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-units--slug--extracurriculars"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/units/{slug}/extracurriculars</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-units--slug--extracurriculars"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-units--slug--extracurriculars"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="GETapi-v1-units--slug--extracurriculars"
               value="smk-mandiri"
               data-component="url">
    <br>
<p>The slug of the school unit. Example: <code>smk-mandiri</code></p>
            </div>
                    </form>

                <h1 id="galleries">Galleries</h1>

    <p>API for querying school activity galleries and multimedia banner content.</p>

                                <h2 id="galleries-GETapi-v1-units--slug--galleries">Get galleries.</h2>

<p>
</p>

<p>Returns a list of galleries for the specified school unit.</p>

<span id="example-requests-GETapi-v1-units--slug--galleries">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/v1/units/smk-mandiri/galleries?opsi_tampilan=galeri_dokumentasi" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/units/smk-mandiri/galleries"
);

const params = {
    "opsi_tampilan": "galeri_dokumentasi",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-units--slug--galleries">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Daftar galeri berhasil diambil.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;nama_kegiatan&quot;: &quot;LDKS OSIS 2026&quot;,
            &quot;opsi_tampilan&quot;: &quot;galeri_dokumentasi&quot;,
            &quot;major_id&quot;: null,
            &quot;photos&quot;: [
                {
                    &quot;id&quot;: 1,
                    &quot;file_foto&quot;: &quot;http://localhost/storage/1/ldks.png&quot;,
                    &quot;urutan&quot;: 1
                }
            ]
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-units--slug--galleries" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-units--slug--galleries"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-units--slug--galleries"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-units--slug--galleries" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-units--slug--galleries">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-units--slug--galleries" data-method="GET"
      data-path="api/v1/units/{slug}/galleries"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-units--slug--galleries', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-units--slug--galleries"
                    onclick="tryItOut('GETapi-v1-units--slug--galleries');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-units--slug--galleries"
                    onclick="cancelTryOut('GETapi-v1-units--slug--galleries');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-units--slug--galleries"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/units/{slug}/galleries</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-units--slug--galleries"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-units--slug--galleries"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="GETapi-v1-units--slug--galleries"
               value="smk-mandiri"
               data-component="url">
    <br>
<p>The slug of the school unit. Example: <code>smk-mandiri</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>opsi_tampilan</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="opsi_tampilan"                data-endpoint="GETapi-v1-units--slug--galleries"
               value="galeri_dokumentasi"
               data-component="query">
    <br>
<p>Filter galleries by display option: <code>hero_section</code>, <code>gambar_pembuka</code>, <code>galeri_dokumentasi</code>, or <code>galeri_program</code>. Example: <code>galeri_dokumentasi</code></p>
            </div>
                </form>

                    <h2 id="galleries-GETapi-v1-units--slug--galleries--id-">Get gallery details.</h2>

<p>
</p>

<p>Returns a specific gallery details along with all associated photos.</p>

<span id="example-requests-GETapi-v1-units--slug--galleries--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/v1/units/smk-mandiri/galleries/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/units/smk-mandiri/galleries/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-units--slug--galleries--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Detail galeri berhasil diambil.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;nama_kegiatan&quot;: &quot;LDKS OSIS 2026&quot;,
        &quot;opsi_tampilan&quot;: &quot;galeri_dokumentasi&quot;,
        &quot;major_id&quot;: null,
        &quot;photos&quot;: [
            {
                &quot;id&quot;: 1,
                &quot;file_foto&quot;: &quot;http://localhost/storage/1/ldks.png&quot;,
                &quot;urutan&quot;: 1
            }
        ]
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-units--slug--galleries--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-units--slug--galleries--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-units--slug--galleries--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-units--slug--galleries--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-units--slug--galleries--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-units--slug--galleries--id-" data-method="GET"
      data-path="api/v1/units/{slug}/galleries/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-units--slug--galleries--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-units--slug--galleries--id-"
                    onclick="tryItOut('GETapi-v1-units--slug--galleries--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-units--slug--galleries--id-"
                    onclick="cancelTryOut('GETapi-v1-units--slug--galleries--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-units--slug--galleries--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/units/{slug}/galleries/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-units--slug--galleries--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-units--slug--galleries--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="GETapi-v1-units--slug--galleries--id-"
               value="smk-mandiri"
               data-component="url">
    <br>
<p>The slug of the school unit. Example: <code>smk-mandiri</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-units--slug--galleries--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the gallery. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="majors">Majors</h1>

    <p>API for querying SMK majors/competencies. Note: Only available for units of type 'smk'.</p>

                                <h2 id="majors-GETapi-v1-units--slug--majors">Get majors list.</h2>

<p>
</p>

<p>Returns a list of majors/programs of study for the specified unit. Returns 404 if the unit is not a SMK.</p>

<span id="example-requests-GETapi-v1-units--slug--majors">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/v1/units/smk-mandiri/majors" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/units/smk-mandiri/majors"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-units--slug--majors">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Daftar jurusan berhasil diambil.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;nama_jurusan&quot;: &quot;Teknik Komputer dan Jaringan&quot;,
            &quot;nomenklatur_istilah&quot;: &quot;Teknik Komputer dan Jaringan&quot;,
            &quot;shortname&quot;: &quot;TKJ&quot;,
            &quot;nama_kaprog&quot;: &quot;Pak Budi&quot;,
            &quot;foto_kaprog&quot;: &quot;http://localhost/storage/1/kaprog.png&quot;,
            &quot;deskripsi_jurusan&quot;: &quot;Deskripsi TKJ...&quot;,
            &quot;galeri_program&quot;: []
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-units--slug--majors" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-units--slug--majors"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-units--slug--majors"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-units--slug--majors" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-units--slug--majors">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-units--slug--majors" data-method="GET"
      data-path="api/v1/units/{slug}/majors"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-units--slug--majors', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-units--slug--majors"
                    onclick="tryItOut('GETapi-v1-units--slug--majors');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-units--slug--majors"
                    onclick="cancelTryOut('GETapi-v1-units--slug--majors');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-units--slug--majors"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/units/{slug}/majors</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-units--slug--majors"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-units--slug--majors"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="GETapi-v1-units--slug--majors"
               value="smk-mandiri"
               data-component="url">
    <br>
<p>The slug of the school unit. Example: <code>smk-mandiri</code></p>
            </div>
                    </form>

                    <h2 id="majors-GETapi-v1-units--slug--majors--id-">Get major details.</h2>

<p>
</p>

<p>Returns detailed information for a specific major, including associated galleries and Kaprog data. Returns 404 if the unit is not a SMK.</p>

<span id="example-requests-GETapi-v1-units--slug--majors--id-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/v1/units/smk-mandiri/majors/1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/units/smk-mandiri/majors/1"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-units--slug--majors--id-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Detail jurusan berhasil diambil.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;nama_jurusan&quot;: &quot;Teknik Komputer dan Jaringan&quot;,
        &quot;nomenklatur_istilah&quot;: &quot;Teknik Komputer dan Jaringan&quot;,
        &quot;shortname&quot;: &quot;TKJ&quot;,
        &quot;nama_kaprog&quot;: &quot;Pak Budi&quot;,
        &quot;foto_kaprog&quot;: &quot;http://localhost/storage/1/kaprog.png&quot;,
        &quot;deskripsi_jurusan&quot;: &quot;Deskripsi TKJ...&quot;,
        &quot;galeri_program&quot;: []
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-units--slug--majors--id-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-units--slug--majors--id-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-units--slug--majors--id-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-units--slug--majors--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-units--slug--majors--id-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-units--slug--majors--id-" data-method="GET"
      data-path="api/v1/units/{slug}/majors/{id}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-units--slug--majors--id-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-units--slug--majors--id-"
                    onclick="tryItOut('GETapi-v1-units--slug--majors--id-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-units--slug--majors--id-"
                    onclick="cancelTryOut('GETapi-v1-units--slug--majors--id-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-units--slug--majors--id-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/units/{slug}/majors/{id}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-units--slug--majors--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-units--slug--majors--id-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="GETapi-v1-units--slug--majors--id-"
               value="smk-mandiri"
               data-component="url">
    <br>
<p>The slug of the school unit. Example: <code>smk-mandiri</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>id</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="id"                data-endpoint="GETapi-v1-units--slug--majors--id-"
               value="1"
               data-component="url">
    <br>
<p>The ID of the major. Example: <code>1</code></p>
            </div>
                    </form>

                <h1 id="news">News</h1>

    <p>API for querying news and articles from school units.</p>

                                <h2 id="news-GETapi-v1-units--slug--news">Get news listing.</h2>

<p>
</p>

<p>Returns a paginated list of published news articles for the specified unit.</p>

<span id="example-requests-GETapi-v1-units--slug--news">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/v1/units/smk-mandiri/news?per_page=10&amp;page=1" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/units/smk-mandiri/news"
);

const params = {
    "per_page": "10",
    "page": "1",
};
Object.keys(params)
    .forEach(key =&gt; url.searchParams.append(key, params[key]));

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-units--slug--news">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Daftar berita berhasil diambil.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;judul_berita&quot;: &quot;Pendaftaran Siswa Baru&quot;,
            &quot;slug&quot;: &quot;pendaftaran-siswa-baru&quot;,
            &quot;konten_berita&quot;: &quot;Pendaftaran...&quot;,
            &quot;gambar_utama&quot;: &quot;http://localhost/storage/1/news.png&quot;,
            &quot;published_at&quot;: &quot;2026-06-11T12:00:00Z&quot;
        }
    ],
    &quot;meta&quot;: {
        &quot;current_page&quot;: 1,
        &quot;from&quot;: 1,
        &quot;last_page&quot;: 1,
        &quot;per_page&quot;: 10,
        &quot;to&quot;: 1,
        &quot;total&quot;: 1
    },
    &quot;links&quot;: {
        &quot;first&quot;: &quot;http://localhost/api/v1/units/smk-mandiri/news?page=1&quot;,
        &quot;last&quot;: &quot;http://localhost/api/v1/units/smk-mandiri/news?page=1&quot;,
        &quot;prev&quot;: null,
        &quot;next&quot;: null
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-units--slug--news" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-units--slug--news"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-units--slug--news"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-units--slug--news" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-units--slug--news">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-units--slug--news" data-method="GET"
      data-path="api/v1/units/{slug}/news"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-units--slug--news', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-units--slug--news"
                    onclick="tryItOut('GETapi-v1-units--slug--news');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-units--slug--news"
                    onclick="cancelTryOut('GETapi-v1-units--slug--news');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-units--slug--news"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/units/{slug}/news</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-units--slug--news"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-units--slug--news"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="GETapi-v1-units--slug--news"
               value="smk-mandiri"
               data-component="url">
    <br>
<p>The slug of the school unit. Example: <code>smk-mandiri</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>Query Parameters</b></h4>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>per_page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="per_page"                data-endpoint="GETapi-v1-units--slug--news"
               value="10"
               data-component="query">
    <br>
<p>Number of articles per page. Default: 10. Example: <code>10</code></p>
            </div>
                                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>page</code></b>&nbsp;&nbsp;
<small>integer</small>&nbsp;
<i>optional</i> &nbsp;
 &nbsp;
                <input type="number" style="display: none"
               step="any"               name="page"                data-endpoint="GETapi-v1-units--slug--news"
               value="1"
               data-component="query">
    <br>
<p>Page number. Example: <code>1</code></p>
            </div>
                </form>

                    <h2 id="news-GETapi-v1-units--slug--news--newsSlug-">Get news detail.</h2>

<p>
</p>

<p>Returns a specific published news article by its slug.</p>

<span id="example-requests-GETapi-v1-units--slug--news--newsSlug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/v1/units/smk-mandiri/news/pendaftaran-siswa-baru" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/units/smk-mandiri/news/pendaftaran-siswa-baru"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-units--slug--news--newsSlug-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Detail berita berhasil diambil.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;judul_berita&quot;: &quot;Pendaftaran Siswa Baru&quot;,
        &quot;slug&quot;: &quot;pendaftaran-siswa-baru&quot;,
        &quot;konten_berita&quot;: &quot;Pendaftaran...&quot;,
        &quot;gambar_utama&quot;: &quot;http://localhost/storage/1/news.png&quot;,
        &quot;published_at&quot;: &quot;2026-06-11T12:00:00Z&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-units--slug--news--newsSlug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-units--slug--news--newsSlug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-units--slug--news--newsSlug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-units--slug--news--newsSlug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-units--slug--news--newsSlug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-units--slug--news--newsSlug-" data-method="GET"
      data-path="api/v1/units/{slug}/news/{newsSlug}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-units--slug--news--newsSlug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-units--slug--news--newsSlug-"
                    onclick="tryItOut('GETapi-v1-units--slug--news--newsSlug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-units--slug--news--newsSlug-"
                    onclick="cancelTryOut('GETapi-v1-units--slug--news--newsSlug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-units--slug--news--newsSlug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/units/{slug}/news/{newsSlug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-units--slug--news--newsSlug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-units--slug--news--newsSlug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="GETapi-v1-units--slug--news--newsSlug-"
               value="smk-mandiri"
               data-component="url">
    <br>
<p>The slug of the school unit. Example: <code>smk-mandiri</code></p>
            </div>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>newsSlug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="newsSlug"                data-endpoint="GETapi-v1-units--slug--news--newsSlug-"
               value="pendaftaran-siswa-baru"
               data-component="url">
    <br>
<p>The slug of the news article. Example: <code>pendaftaran-siswa-baru</code></p>
            </div>
                    </form>

                <h1 id="spmb">SPMB</h1>

    <p>API for querying school enrollment (SPMB) settings and status.</p>

                                <h2 id="spmb-GETapi-v1-units--slug--spmb">Get SPMB settings.</h2>

<p>
</p>

<p>Returns the SPMB settings of the specified school unit.</p>

<span id="example-requests-GETapi-v1-units--slug--spmb">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/v1/units/smk-mandiri/spmb" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/units/smk-mandiri/spmb"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-units--slug--spmb">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Pengaturan SPMB berhasil diambil.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;status_spmb&quot;: true,
        &quot;informasi_prosedur&quot;: &quot;Berikut adalah prosedur pendaftaran...&quot;,
        &quot;url_eksternal_pendaftaran&quot;: &quot;https://ppdb.example.com&quot;
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-units--slug--spmb" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-units--slug--spmb"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-units--slug--spmb"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-units--slug--spmb" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-units--slug--spmb">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-units--slug--spmb" data-method="GET"
      data-path="api/v1/units/{slug}/spmb"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-units--slug--spmb', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-units--slug--spmb"
                    onclick="tryItOut('GETapi-v1-units--slug--spmb');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-units--slug--spmb"
                    onclick="cancelTryOut('GETapi-v1-units--slug--spmb');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-units--slug--spmb"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/units/{slug}/spmb</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-units--slug--spmb"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-units--slug--spmb"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="GETapi-v1-units--slug--spmb"
               value="smk-mandiri"
               data-component="url">
    <br>
<p>The slug of the school unit. Example: <code>smk-mandiri</code></p>
            </div>
                    </form>

                <h1 id="units">Units</h1>

    <p>API for managing and querying school units.</p>

                                <h2 id="units-GETapi-v1-units">Get active units.</h2>

<p>
</p>

<p>Returns a list of all active school units.</p>

<span id="example-requests-GETapi-v1-units">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/v1/units" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/units"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-units">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Daftar unit sekolah berhasil diambil.&quot;,
    &quot;data&quot;: [
        {
            &quot;id&quot;: 1,
            &quot;nama_sekolah&quot;: &quot;SMK Mandiri&quot;,
            &quot;slug&quot;: &quot;smk-mandiri&quot;,
            &quot;jenjang&quot;: &quot;smk&quot;,
            &quot;is_active&quot;: true,
            &quot;logo_sekolah&quot;: &quot;http://localhost/storage/1/logo.png&quot;
        }
    ]
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-units" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-units"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-units"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-units" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-units">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-units" data-method="GET"
      data-path="api/v1/units"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-units', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-units"
                    onclick="tryItOut('GETapi-v1-units');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-units"
                    onclick="cancelTryOut('GETapi-v1-units');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-units"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/units</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-units"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-units"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        </form>

                    <h2 id="units-GETapi-v1-units--slug-">Get unit details.</h2>

<p>
</p>

<p>Returns the full school profile of the specified unit slug.</p>

<span id="example-requests-GETapi-v1-units--slug-">
<blockquote>Example request:</blockquote>


<div class="bash-example">
    <pre><code class="language-bash">curl --request GET \
    --get "http://localhost/api/v1/units/smk-mandiri" \
    --header "Content-Type: application/json" \
    --header "Accept: application/json"</code></pre></div>


<div class="javascript-example">
    <pre><code class="language-javascript">const url = new URL(
    "http://localhost/api/v1/units/smk-mandiri"
);

const headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response =&gt; response.json());</code></pre></div>

</span>

<span id="example-responses-GETapi-v1-units--slug-">
            <blockquote>
            <p>Example response (200):</p>
        </blockquote>
                <pre>

<code class="language-json" style="max-height: 300px;">{
    &quot;success&quot;: true,
    &quot;message&quot;: &quot;Detail unit sekolah berhasil diambil.&quot;,
    &quot;data&quot;: {
        &quot;id&quot;: 1,
        &quot;nama_sekolah&quot;: &quot;SMK Mandiri&quot;,
        &quot;slug&quot;: &quot;smk-mandiri&quot;,
        &quot;jenjang&quot;: &quot;smk&quot;,
        &quot;is_active&quot;: true,
        &quot;logo_sekolah&quot;: &quot;http://localhost/storage/1/logo.png&quot;,
        &quot;profile&quot;: {
            &quot;id&quot;: 1,
            &quot;unit_id&quot;: 1,
            &quot;logo_sekolah&quot;: &quot;http://localhost/storage/1/logo.png&quot;,
            &quot;email&quot;: &quot;smk@mandiri.sch.id&quot;,
            &quot;telepon&quot;: &quot;021-123456&quot;,
            &quot;alamat&quot;: &quot;Jl. Mandiri No. 1&quot;,
            &quot;google_map_embed_url&quot;: &quot;https://maps...&quot;,
            &quot;media_sosial&quot;: {
                &quot;facebook&quot;: &quot;https://...&quot;
            }
        }
    }
}</code>
 </pre>
    </span>
<span id="execution-results-GETapi-v1-units--slug-" hidden>
    <blockquote>Received response<span
                id="execution-response-status-GETapi-v1-units--slug-"></span>:
    </blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-v1-units--slug-"
      data-empty-response-text="<Empty response>" style="max-height: 400px;"></code></pre>
</span>
<span id="execution-error-GETapi-v1-units--slug-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-v1-units--slug-">

Tip: Check that you&#039;re properly connected to the network.
If you&#039;re a maintainer of ths API, verify that your API is running and you&#039;ve enabled CORS.
You can check the Dev Tools console for debugging information.</code></pre>
</span>
<form id="form-GETapi-v1-units--slug-" data-method="GET"
      data-path="api/v1/units/{slug}"
      data-authed="0"
      data-hasfiles="0"
      data-isarraybody="0"
      autocomplete="off"
      onsubmit="event.preventDefault(); executeTryOut('GETapi-v1-units--slug-', this);">
    <h3>
        Request&nbsp;&nbsp;&nbsp;
                    <button type="button"
                    style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-tryout-GETapi-v1-units--slug-"
                    onclick="tryItOut('GETapi-v1-units--slug-');">Try it out ⚡
            </button>
            <button type="button"
                    style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-canceltryout-GETapi-v1-units--slug-"
                    onclick="cancelTryOut('GETapi-v1-units--slug-');" hidden>Cancel 🛑
            </button>&nbsp;&nbsp;
            <button type="submit"
                    style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;"
                    id="btn-executetryout-GETapi-v1-units--slug-"
                    data-initial-text="Send Request 💥"
                    data-loading-text="⏱ Sending..."
                    hidden>Send Request 💥
            </button>
            </h3>
            <p>
            <small class="badge badge-green">GET</small>
            <b><code>api/v1/units/{slug}</code></b>
        </p>
                <h4 class="fancy-heading-panel"><b>Headers</b></h4>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Content-Type</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Content-Type"                data-endpoint="GETapi-v1-units--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                                <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>Accept</code></b>&nbsp;&nbsp;
&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="Accept"                data-endpoint="GETapi-v1-units--slug-"
               value="application/json"
               data-component="header">
    <br>
<p>Example: <code>application/json</code></p>
            </div>
                        <h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
                    <div style="padding-left: 28px; clear: unset;">
                <b style="line-height: 2;"><code>slug</code></b>&nbsp;&nbsp;
<small>string</small>&nbsp;
 &nbsp;
 &nbsp;
                <input type="text" style="display: none"
                              name="slug"                data-endpoint="GETapi-v1-units--slug-"
               value="smk-mandiri"
               data-component="url">
    <br>
<p>The slug of the school unit. Example: <code>smk-mandiri</code></p>
            </div>
                    </form>

            

        
    </div>
    <div class="dark-box">
                    <div class="lang-selector">
                                                        <button type="button" class="lang-button" data-language-name="bash">bash</button>
                                                        <button type="button" class="lang-button" data-language-name="javascript">javascript</button>
                            </div>
            </div>
</div>
</body>
</html>
