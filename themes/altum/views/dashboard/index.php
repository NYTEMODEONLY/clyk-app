<?php defined('ALTUMCODE') || die() ?>

<div class="container mx-auto px-4 py-8">
    <?= \Altum\Alerts::output_alerts() ?>

    <?php
    $enabled_links = [];
    if(settings()->links->biolinks_is_enabled) $enabled_links[] = 'biolink';
    if(settings()->links->shortener_is_enabled) $enabled_links[] = 'link';
    if(settings()->links->files_is_enabled) $enabled_links[] = 'file';
    if(settings()->links->vcards_is_enabled) $enabled_links[] = 'vcard';
    if(settings()->links->events_is_enabled) $enabled_links[] = 'event';
    if(settings()->links->static_is_enabled) $enabled_links[] = 'static';
    $enabled_links_count = count($enabled_links);

    $grid_cols = match ($enabled_links_count) {
        1 => 'grid-cols-1',
        2, 4 => 'grid-cols-1 md:grid-cols-2',
        3, 5, 6 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
        default => 'grid-cols-1',
    };
    ?>

    <div class="mb-8">
        <div class="grid <?= $grid_cols ?> gap-6">
            <?php if(settings()->links->biolinks_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                            <a href="<?= url('links?type=biolink') ?>" class="text-blue-600 dark:text-blue-400">
                                <i class="fas fa-hashtag fa-lg"></i>
                            </a>
                        </div>

                        <div class="flex-1">
                            <div class="text-3xl font-bold text-primary" id="biolink_links_total">
                                <div class="animate-spin w-6 h-6 border-2 border-primary border-t-transparent rounded-full mx-auto"></div>
                            </div>
                            <p class="text-muted-foreground font-medium"><?= l('dashboard.biolinks') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if(settings()->links->shortener_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-teal-100 dark:bg-teal-900/20 rounded-lg flex items-center justify-center">
                            <a href="<?= url('links?type=link') ?>" class="text-teal-600 dark:text-teal-400">
                                <i class="fas fa-link fa-lg"></i>
                            </a>
                        </div>

                        <div class="flex-1">
                            <div class="text-3xl font-bold text-primary" id="link_links_total">
                                <div class="animate-spin w-6 h-6 border-2 border-primary border-t-transparent rounded-full mx-auto"></div>
                            </div>
                            <p class="text-muted-foreground font-medium"><?= l('dashboard.links') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if(settings()->links->files_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                            <a href="<?= url('links?type=file') ?>" class="text-green-600 dark:text-green-400">
                                <i class="fas fa-file fa-lg"></i>
                            </a>
                        </div>

                        <div class="flex-1">
                            <div class="text-3xl font-bold text-primary" id="file_links_total">
                                <div class="animate-spin w-6 h-6 border-2 border-primary border-t-transparent rounded-full mx-auto"></div>
                            </div>
                            <p class="text-muted-foreground font-medium"><?= l('dashboard.file_links') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if(settings()->links->vcards_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-cyan-100 dark:bg-cyan-900/20 rounded-lg flex items-center justify-center">
                            <a href="<?= url('links?type=vcard') ?>" class="text-cyan-600 dark:text-cyan-400">
                                <i class="fas fa-id-card fa-lg"></i>
                            </a>
                        </div>

                        <div class="flex-1">
                            <div class="text-3xl font-bold text-primary" id="vcard_links_total">
                                <div class="animate-spin w-6 h-6 border-2 border-primary border-t-transparent rounded-full mx-auto"></div>
                            </div>
                            <p class="text-muted-foreground font-medium"><?= l('dashboard.vcard_links') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if(settings()->links->events_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center">
                            <a href="<?= url('links?type=event') ?>" class="text-indigo-600 dark:text-indigo-400">
                                <i class="fas fa-calendar fa-lg"></i>
                            </a>
                        </div>

                        <div class="flex-1">
                            <div class="text-3xl font-bold text-primary" id="event_links_total">
                                <div class="animate-spin w-6 h-6 border-2 border-primary border-t-transparent rounded-full mx-auto"></div>
                            </div>
                            <p class="text-muted-foreground font-medium"><?= l('dashboard.event_links') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if(settings()->links->static_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                            <a href="<?= url('links?type=static') ?>" class="text-purple-600 dark:text-purple-400">
                                <i class="fas fa-file-code fa-lg"></i>
                            </a>
                        </div>

                        <div class="flex-1">
                            <div class="text-3xl font-bold text-primary" id="static_links_total">
                                <div class="animate-spin w-6 h-6 border-2 border-primary border-t-transparent rounded-full mx-auto"></div>
                            </div>
                            <p class="text-muted-foreground font-medium"><?= l('dashboard.static_links') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>

        <div class="card mt-8">
            <div class="card-header">
                <h3 class="card-title text-xl font-semibold">
                    <?= l('dashboard.analytics') ?>
                </h3>
            </div>
            <div class="card-content p-6">
                <div class="hidden h-80" id="pageviews_chart_container">
                    <canvas id="pageviews_chart"></canvas>
                </div>

                <div id="pageviews_chart_no_data" class="hidden">
                    <?= include_view(THEME_PATH . 'views/partials/no_chart_data.php', ['has_wrapper' => false]); ?>
                </div>

                <div id="pageviews_chart_loading" class="h-80 flex items-center justify-center">
                    <div class="animate-spin w-8 h-8 border-4 border-primary border-t-transparent rounded-full"></div>
                </div>

                <?php if(settings()->main->chart_cache): ?>
                <p class="text-muted-foreground text-sm mt-4 hidden" id="pageviews_chart_help">
                    <i class="fas fa-info-circle mr-1"></i>
                    <?= sprintf(l('global.chart_help'), settings()->main->chart_cache ?? 12, settings()->main->chart_days ?? 30) ?>
                </p>
                <?php endif ?>
            </div>
        </div>

        <?php require THEME_PATH . 'views/partials/js_chart_defaults.php' ?>
    </div>

    <?= $this->views['links_content'] ?>
</div>

<?php ob_start() ?>
    <script>
    'use strict';
    
        (async function fetch_statistics() {
            /* Send request to server */
            let response = await fetch(`${url}dashboard/get_stats_ajax`, {
                method: 'get',
            });

            let data = null;
            try {
                data = await response.json();
            } catch (error) {
                /* :)  */
            }

            if(!response.ok) {
                /* :)  */
            }

            if(data.status == 'error') {
                /* :)  */
            } else if(data.status == 'success') {

                /* update link_links_total */
                const link_links_total_element = document.querySelector('#link_links_total');
                if (link_links_total_element) {
                    link_links_total_element.innerHTML = data.details.link_links_total ? nr(data.details.link_links_total) : 0;
                }

                /* update file_links_total */
                const file_links_total_element = document.querySelector('#file_links_total');
                if (file_links_total_element) {
                    file_links_total_element.innerHTML = data.details.file_links_total ? nr(data.details.file_links_total) : 0;
                }

                /* update vcard_links_total */
                const vcard_links_total_element = document.querySelector('#vcard_links_total');
                if (vcard_links_total_element) {
                    vcard_links_total_element.innerHTML = data.details.vcard_links_total ? nr(data.details.vcard_links_total) : 0;
                }

                /* update biolink_links_total */
                const biolink_links_total_element = document.querySelector('#biolink_links_total');
                if (biolink_links_total_element) {
                    biolink_links_total_element.innerHTML = data.details.biolink_links_total ? nr(data.details.biolink_links_total) : 0;
                }

                /* update event_links_total */
                const event_links_total_element = document.querySelector('#event_links_total');
                if (event_links_total_element) {
                    event_links_total_element.innerHTML = data.details.event_links_total ? nr(data.details.event_links_total) : 0;
                }

                /* update static_links_total */
                const static_links_total_element = document.querySelector('#static_links_total');
                if (static_links_total_element) {
                    static_links_total_element.innerHTML = data.details.static_links_total ? nr(data.details.static_links_total) : 0;
                }

                /* Remove loading */
                document.querySelector('#pageviews_chart_loading').classList.add('hidden');

                /* Chart */
                if(data.details.links_chart.is_empty) {
                    document.querySelector('#pageviews_chart_no_data').classList.remove('hidden');
                } else {
                    /* Display chart data */
                    document.querySelector('#pageviews_chart_container').classList.remove('hidden');
                    document.querySelector('#pageviews_chart_help') && document.querySelector('#pageviews_chart_help').classList.remove('hidden');

                    let css = window.getComputedStyle(document.body);
                    let pageviews_color = css.getPropertyValue('--primary');
                    let visitors_color = css.getPropertyValue('--gray-300');
                    let pageviews_color_gradient = null;
                    let visitors_color_gradient = null;

                    /* Chart */
                    let pageviews_chart = document.getElementById('pageviews_chart').getContext('2d');

                    /* Colors */
                    pageviews_color_gradient = pageviews_chart.createLinearGradient(0, 0, 0, 250);
                    pageviews_color_gradient.addColorStop(0, set_hex_opacity(pageviews_color, 0.6));
                    pageviews_color_gradient.addColorStop(1, set_hex_opacity(pageviews_color, 0.1));

                    visitors_color_gradient = pageviews_chart.createLinearGradient(0, 0, 0, 250);
                    visitors_color_gradient.addColorStop(0, set_hex_opacity(visitors_color, 0.6));
                    visitors_color_gradient.addColorStop(1, set_hex_opacity(visitors_color, 0.1));

                    new Chart(pageviews_chart, {
                        type: 'line',
                        data: {
                            labels: JSON.parse(data.details.links_chart.labels ?? '[]'),
                            datasets: [
                                {
                                    label: <?= json_encode(l('link.statistics.pageviews')) ?>,
                                    data: JSON.parse(data.details.links_chart.pageviews ?? '[]'),
                                    backgroundColor: pageviews_color_gradient,
                                    borderColor: pageviews_color,
                                    fill: true
                                },
                                {
                                    label: <?= json_encode(l('link.statistics.visitors')) ?>,
                                    data: JSON.parse(data.details.links_chart.visitors ?? '[]'),
                                    backgroundColor: visitors_color_gradient,
                                    borderColor: visitors_color,
                                    fill: true
                                }
                            ]
                        },
                        options: chart_options
                    });
                }
            }
        })();
    </script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>
