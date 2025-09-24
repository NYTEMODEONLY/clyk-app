<?php defined('ALTUMCODE') || die() ?>

<section class="relative min-h-screen flex items-center bg-gradient-to-br from-background via-background to-muted/20">
    <div class="container mx-auto px-4 py-16">
        <?= \Altum\Alerts::output_alerts() ?>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <!-- Hero Content -->
            <div class="space-y-8">
                <div class="flex items-center gap-2">
                    <div class="badge badge-default flex items-center gap-1">
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <i class="fas fa-star text-yellow-500"></i>
                        <span class="ml-1">
                            <?= sprintf(l('index.stars'), '<span class="font-bold">' . nr($data->total_users) . '+</span>') ?>
                        </span>
                    </div>
                </div>

                <h1 class="text-4xl lg:text-6xl font-bold tracking-tight">
                    <?= l('index.header') ?>
                </h1>

                <!-- Feature Pills -->
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-3">
                    <?php if(settings()->links->biolinks_is_enabled): ?>
                        <a href="<?= url('links?type=biolink') ?>" class="btn btn-outline px-4 py-2 text-sm hover:bg-accent hover:text-accent-foreground transition-colors">
                            <?= l('index.subheader.biolink') ?>
                        </a>
                    <?php endif ?>

                    <?php if(settings()->links->shortener_is_enabled): ?>
                        <a href="<?= url('links?type=link') ?>" class="btn btn-outline px-4 py-2 text-sm hover:bg-accent hover:text-accent-foreground transition-colors">
                            <?= l('index.subheader.link') ?>
                        </a>
                    <?php endif ?>

                    <?php if(settings()->links->files_is_enabled): ?>
                        <a href="<?= url('links?type=file') ?>" class="btn btn-outline px-4 py-2 text-sm hover:bg-accent hover:text-accent-foreground transition-colors">
                            <?= l('index.subheader.file') ?>
                        </a>
                    <?php endif ?>

                    <?php if(settings()->links->vcards_is_enabled): ?>
                        <a href="<?= url('links?type=vcard') ?>" class="btn btn-outline px-4 py-2 text-sm hover:bg-accent hover:text-accent-foreground transition-colors">
                            <?= l('index.subheader.vcard') ?>
                        </a>
                    <?php endif ?>

                    <?php if(settings()->links->events_is_enabled): ?>
                        <a href="<?= url('links?type=event') ?>" class="btn btn-outline px-4 py-2 text-sm hover:bg-accent hover:text-accent-foreground transition-colors">
                            <?= l('index.subheader.event') ?>
                        </a>
                    <?php endif ?>

                    <?php if(settings()->links->static_is_enabled): ?>
                        <a href="<?= url('links?type=static') ?>" class="btn btn-outline px-4 py-2 text-sm hover:bg-accent hover:text-accent-foreground transition-colors">
                            <?= l('index.subheader.static') ?>
                        </a>
                    <?php endif ?>

                    <?php if(settings()->codes->qr_codes_is_enabled): ?>
                        <a href="<?= url('qr-codes') ?>" class="btn btn-outline px-4 py-2 text-sm hover:bg-accent hover:text-accent-foreground transition-colors">
                            <?= l('index.subheader.qr_codes') ?>
                        </a>
                    <?php endif ?>

                    <?php if(settings()->tools->is_enabled): ?>
                        <a href="<?= url('tools') ?>" class="btn btn-outline px-4 py-2 text-sm hover:bg-accent hover:text-accent-foreground transition-colors">
                            <?= l('index.subheader.tools') ?>
                        </a>
                    <?php endif ?>

                    <?php if(settings()->links->biolinks_is_enabled ||settings()->links->shortener_is_enabled ||settings()->links->files_is_enabled ||settings()->links->vcards_is_enabled ||settings()->links->events_is_enabled ||settings()->links->static_is_enabled): ?>
                        <a href="<?= url('links-statistics') ?>" class="btn btn-outline px-4 py-2 text-sm hover:bg-accent hover:text-accent-foreground transition-colors">
                            <?= l('index.subheader.analytics') ?>
                        </a>
                    <?php endif ?>
                </div>

                <!-- CTA Section -->
                <div class="space-y-4">
                    <?php if(is_logged_in()): ?>
                        <a href="<?= url('dashboard') ?>" class="btn btn-default btn-lg w-full lg:w-auto">
                            <?= l('dashboard.menu') ?> <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    <?php elseif(settings()->users->register_is_enabled): ?>
                        <?php if(settings()->links->claim_url_is_enabled): ?>
                            <div class="space-y-3">
                                <div class="flex flex-col lg:flex-row gap-2">
                                    <?php if(count($data->domains)): ?>
                                        <select id="domain_id" name="domain_id" class="input flex-shrink-0 lg:w-48">
                                            <?php if(settings()->links->main_domain_is_enabled): ?>
                                                <option value=" " data-full-url="<?= SITE_URL ?>"><?= remove_url_protocol_from_url(SITE_URL) ?></option>
                                            <?php endif ?>
                                            <?php foreach($data->domains as $row): ?>
                                                <option value="<?= $row->domain_id ?>" data-full-url="<?= $row->url ?>" data-type="<?= $row->type ?>"><?= remove_url_protocol_from_url($row->url) ?></option>
                                            <?php endforeach ?>
                                        </select>
                                    <?php else: ?>
                                        <div class="input flex-shrink-0 lg:w-48 bg-muted">
                                            <?= remove_url_protocol_from_url(SITE_URL) ?>
                                        </div>
                                    <?php endif ?>
                                    <input id="claim_url" type="text" name="url" class="input flex-1" value="" maxlength="<?= $this->user->plan_settings->url_maximum_characters ?? 64 ?>" placeholder="<?= l('index.claim_placeholder') ?>" />
                                </div>

                                <?php ob_start() ?>
                                    <script>
    'use strict';

                                        let claim_button_default_href = document.querySelector('#claim_button').href;
                                        ['change', 'paste', 'keyup', 'keypress'].forEach(event_type => document.querySelector('#claim_url').addEventListener(event_type, event => {
                                            let url = get_slug(document.querySelector('#claim_url').value);
                                            let domain_id_element = document.querySelector('#domain_id');
                                            let domain_id = domain_id_element ? domain_id_element.value : null;

                                            let query_params = new URLSearchParams();
                                            if(url) query_params.set('claim-url', url);
                                            if(domain_id) query_params.set('domain-id', domain_id);

                                            document.querySelector('#claim_button').href = query_params.toString()
                                                ? `${claim_button_default_href}?${query_params}`
                                                : claim_button_default_href;

                                            if(event.key === 'Enter') {
                                                event.preventDefault();
                                                document.querySelector('#claim_button').click();
                                            }
                                        }));
                                    </script>
                                <?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

                                <a id="claim_button" href="<?= url('register') ?>" class="btn btn-default btn-lg w-full lg:w-auto">
                                    <?= l(settings()->links->claim_url_is_enabled ? 'index.claim' : 'index.sign_up') ?> <i class="fas fa-arrow-right ml-2"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <a href="<?= url('register') ?>" class="btn btn-default btn-lg w-full lg:w-auto">
                                <?= l('index.sign_up') ?> <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        <?php endif ?>
                    <?php endif ?>

                    <?php //ALTUMCODE:DEMO if(!DEMO): ?>
                    <?php if(settings()->links->biolinks_is_enabled && settings()->links->example_url && !settings()->links->claim_url_is_enabled): ?>
                        <a href="<?= settings()->links->example_url ?>" target="_blank" class="btn btn-outline btn-lg">
                            <?= l('index.example') ?> <i class="fas fa-external-link-alt ml-2"></i>
                        </a>
                    <?php endif ?>
                    <?php //ALTUMCODE:DEMO endif ?>
                </div>
            </div>

            <!-- Hero Images -->
            <div class="hidden lg:flex justify-center relative">
                <div class="relative">
                    <img src="<?= get_custom_image_if_any('index/hero-one.webp') ?>" class="w-80 h-auto rounded-lg shadow-2xl" alt="<?= l('index.hero_image_alt') ?>" />
                    <img src="<?= get_custom_image_if_any('index/hero-two.webp') ?>" class="w-64 h-auto rounded-lg shadow-xl absolute -top-8 -right-8" alt="<?= l('index.hero_image_alt') ?>" />
                </div>
            </div>
        </div>
    </div>
</section>

<?php if(settings()->links->biolinks_is_enabled): ?>
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="card max-w-6xl mx-auto" data-aos="fade-up">
            <div class="grid lg:grid-cols-2 gap-8 p-8">
                <div>
                    <img src="<?= get_custom_image_if_any('index/bio-link.webp') ?>" class="w-full h-auto rounded-lg" loading="lazy" alt="<?= l('index.biolink_image_alt') ?>" />
                </div>
                <div class="space-y-6">
                    <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users fa-xl text-primary"></i>
                    </div>

                    <h2 class="text-3xl font-bold"><?= l('index.presentation1.header') ?></h2>
                    <p class="text-muted-foreground text-lg"><?= l('index.presentation1.subheader') ?></p>

                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation1.feature1') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation1.feature2') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation1.feature3') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation1.feature4') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation1.feature5') ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif ?>

<?php if(settings()->links->shortener_is_enabled): ?>
<section class="py-16 bg-muted/30">
    <div class="container mx-auto px-4">
        <div class="card max-w-6xl mx-auto" data-aos="fade-up">
            <div class="grid lg:grid-cols-2 gap-8 p-8">
                <div>
                    <img src="<?= get_custom_image_if_any('index/short-link.webp') ?>" class="w-full h-auto rounded-lg" loading="lazy" alt="<?= l('index.short_image_alt') ?>" />
                </div>
                <div class="space-y-6">
                    <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-link fa-xl text-primary"></i>
                    </div>

                    <h2 class="text-3xl font-bold"><?= l('index.presentation2.header') ?></h2>
                    <p class="text-muted-foreground text-lg"><?= l('index.presentation2.subheader') ?></p>

                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation2.feature1') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation2.feature2') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation2.feature3') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation2.feature4') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation2.feature5') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation2.feature6') ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif ?>

<?php if(settings()->links->static_is_enabled): ?>
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="card max-w-6xl mx-auto" data-aos="fade-up">
            <div class="grid lg:grid-cols-2 gap-8 p-8">
                <div>
                    <img src="<?= get_custom_image_if_any('index/static-link.webp') ?>" class="w-full h-auto rounded-lg" loading="lazy" alt="<?= l('index.static_image_alt') ?>" />
                </div>
                <div class="space-y-6">
                    <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-code fa-xl text-primary"></i>
                    </div>

                    <h2 class="text-3xl font-bold"><?= l('index.presentation5.header') ?></h2>
                    <p class="text-muted-foreground text-lg"><?= l('index.presentation5.subheader') ?></p>

                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation5.feature1') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation5.feature2') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation5.feature3') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation5.feature4') ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif ?>

<?php if(settings()->codes->qr_codes_is_enabled): ?>
<section class="py-16 bg-muted/30">
    <div class="container mx-auto px-4">
        <div class="card max-w-6xl mx-auto" data-aos="fade-up">
            <div class="grid lg:grid-cols-2 gap-8 p-8">
                <div>
                    <img src="<?= get_custom_image_if_any('index/qr-code.webp') ?>" class="w-full h-auto rounded-lg" loading="lazy" alt="<?= l('index.qr_image_alt') ?>" />
                </div>
                <div class="space-y-6">
                    <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-qrcode fa-xl text-primary"></i>
                    </div>

                    <h2 class="text-3xl font-bold"><?= l('index.presentation3.header') ?></h2>
                    <p class="text-muted-foreground text-lg"><?= l('index.presentation3.subheader') ?></p>

                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation3.feature1') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation3.feature2') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation3.feature3') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation3.feature4') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation3.feature5') ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif ?>

<?php if(settings()->links->biolinks_is_enabled ||settings()->links->shortener_is_enabled ||settings()->links->files_is_enabled ||settings()->links->vcards_is_enabled ||settings()->links->events_is_enabled ||settings()->links->static_is_enabled): ?>
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="card max-w-6xl mx-auto" data-aos="fade-up">
            <div class="grid lg:grid-cols-2 gap-8 p-8">
                <div>
                    <img src="<?= get_custom_image_if_any('index/analytics.webp') ?>" class="w-full h-auto rounded-lg" loading="lazy" alt="<?= l('index.analytics_image_alt') ?>" />
                </div>
                <div class="space-y-6">
                    <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center">
                        <i class="fas fa-chart-bar fa-xl text-primary"></i>
                    </div>

                    <h2 class="text-3xl font-bold"><?= l('index.presentation4.header') ?></h2>
                    <p class="text-muted-foreground text-lg"><?= l('index.presentation4.subheader') ?></p>

                    <ul class="space-y-3">
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation4.feature1') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation4.feature2') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation4.feature3') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation4.feature4') ?></span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span><?= l('index.presentation4.feature5') ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif ?>

<!-- Feature Cards Section -->
<section class="py-16 bg-muted/30">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php if(settings()->links->files_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="100">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-file fa-lg text-green-600 dark:text-green-400"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg"><?= l('index.file_links.header') ?></h3>
                            <p class="text-muted-foreground text-sm"><?= l('index.file_links.subheader') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if(settings()->links->vcards_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="200">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-cyan-100 dark:bg-cyan-900/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-id-card fa-lg text-cyan-600 dark:text-cyan-400"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg"><?= l('index.vcard_links.header') ?></h3>
                            <p class="text-muted-foreground text-sm"><?= l('index.vcard_links.subheader') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if(settings()->links->events_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="300">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-calendar fa-lg text-indigo-600 dark:text-indigo-400"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg"><?= l('index.event_links.header') ?></h3>
                            <p class="text-muted-foreground text-sm"><?= l('index.event_links.subheader') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if(settings()->links->splash_page_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="400">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-teal-100 dark:bg-teal-900/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-droplet fa-lg text-teal-600 dark:text-teal-400"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg"><?= l('index.splash_pages.header') ?></h3>
                            <p class="text-muted-foreground text-sm"><?= l('index.splash_pages.subheader') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if(settings()->links->domains_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="500">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-globe fa-lg text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg"><?= l('index.domains.header') ?></h3>
                            <p class="text-muted-foreground text-sm"><?= l('index.domains.subheader') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>

            <?php if(settings()->links->projects_is_enabled): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="600">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-pink-100 dark:bg-pink-900/20 rounded-lg flex items-center justify-center">
                            <i class="fas fa-project-diagram fa-lg text-pink-600 dark:text-pink-400"></i>
                        </div>
                        <div>
                            <h3 class="font-semibold text-lg"><?= l('index.projects.header') ?></h3>
                            <p class="text-muted-foreground text-sm"><?= l('index.projects.subheader') ?></p>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</section>

<?php if(settings()->links->shortener_is_enabled): ?>
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="card p-8 text-center">
            <h2 class="text-3xl font-bold mb-4"><?= l('index.shortener_app_linking.header') ?></h2>
            <p class="text-muted-foreground text-lg mb-8"><?= l('index.shortener_app_linking.subheader') ?></p>

            <div class="flex flex-wrap justify-center gap-4">
                <?php foreach(require APP_PATH . 'includes/app_linking.php' as $app_key => $app): ?>
                    <div class="w-16 h-16 bg-muted rounded-lg flex items-center justify-center hover:bg-accent transition-colors" data-toggle="tooltip" title="<?= $app['name'] ?>">
                        <i class="<?= $app['icon'] ?> fa-xl" style="color: <?= $app['color'] ?>"></i>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<?php endif ?>

<!-- Statistics Section -->
<section class="py-16 bg-card">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="space-y-2">
                <p class="text-muted-foreground font-medium"><?= l('index.stats.links') ?></p>
                <p class="text-4xl lg:text-5xl font-bold text-primary"><?= nr($data->total_links, 0, true, true) . '+' ?></p>
            </div>

            <?php if(settings()->codes->qr_codes_is_enabled): ?>
                <div class="space-y-2">
                    <p class="text-muted-foreground font-medium"><?= l('index.stats.qr_codes') ?></p>
                    <p class="text-4xl lg:text-5xl font-bold text-primary"><?= nr($data->total_qr_codes, 0, true, true) . '+' ?></p>
                </div>
            <?php endif ?>

            <div class="space-y-2">
                <p class="text-muted-foreground font-medium"><?= l('index.stats.track_links') ?></p>
                <p class="text-4xl lg:text-5xl font-bold text-primary"><?= nr($data->total_track_links, 0, true, true) . '+' ?></p>
            </div>
        </div>
    </div>
</section>

<?php if(settings()->links->pixels_is_enabled): ?>
<section class="py-16 bg-muted/30">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4"><?= l('index.pixels.header') ?></h2>
            <p class="text-muted-foreground text-lg max-w-2xl mx-auto"><?= l('index.pixels.subheader') ?></p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php $i = 0; ?>
            <?php foreach(require APP_PATH . 'includes/pixels.php' as $item): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="<?= $i * 100 ?>">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center" style="background-color: <?= $item['color'] ?>20;">
                            <i class="<?= $item['icon'] ?> fa-lg" style="color: <?= $item['color'] ?>"></i>
                        </div>
                        <h3 class="font-semibold text-lg"><?= $item['name'] ?></h3>
                    </div>
                </div>
                <?php $i++ ?>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif ?>

<?php if(settings()->tools->is_enabled && $data->enabled_tools): ?>
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">
                <?= sprintf(l('index.tools.header'), nr($data->enabled_tools)) ?>
                <i class="fas fa-screwdriver-wrench text-muted ml-2"></i>
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <?php $i = 1; ?>
            <?php foreach($data->tools_categories as $tool => $tool_properties): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow" data-aos="fade-in" data-aos-delay="<?= $i++ * 100 ?>" style="border-left: 4px solid <?= $tool_properties['color'] ?>;">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0" style="background-color: <?= $tool_properties['faded_color'] ?>;">
                            <i class="<?= $tool_properties['icon'] ?> fa-lg" style="color: <?= $tool_properties['color'] ?>"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold text-lg mb-2">
                                <a href="<?= url('tools') ?>" class="hover:text-primary transition-colors">
                                    <?= l('tools.' . $tool) ?>
                                </a>
                            </h3>
                            <p class="text-muted-foreground text-sm"><?= l('tools.' . $tool . '_help') ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif ?>


<?php if(\Altum\Plugin::is_active('aix') && settings()->aix->images_is_enabled && settings()->aix->images_display_latest_on_index): ?>
<section class="py-16 bg-muted/30">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4"><?= sprintf(l('index.images'), nr($data->total_images, 0, true, true)) ?></h2>
            <p class="text-muted-foreground text-lg"><?= l('index.images_subheader') ?></p>
        </div>

        <div class="card p-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                <?php foreach($data->images as $image): ?>
                    <div data-aos="zoom-in">
                        <img src="<?= \Altum\Uploads::get_full_url('images') . $image->image ?>" class="w-full h-auto rounded-lg hover:shadow-lg transition-shadow" alt="<?= $image->input ?>" data-toggle="tooltip" title="<?= $image->input ?>" loading="lazy" />
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<?php endif ?>

<?php if(\Altum\Plugin::is_active('aix') && settings()->aix->documents_is_enabled): ?>
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="card bg-card p-8 text-center">
            <h3 class="text-2xl font-bold text-card-foreground">
                <?= sprintf(l('index.documents'), nr($data->total_documents, 0, true, true)) ?>
            </h3>
        </div>
    </div>
</section>
<?php endif ?>

<?php if(settings()->main->api_is_enabled): ?>
<section class="py-16 bg-muted/30">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <div class="text-sm font-bold text-primary uppercase tracking-wide">
                    <?= l('index.api.name') ?>
                </div>

                <h2 class="text-3xl font-bold"><?= l('index.api.header') ?></h2>
                <p class="text-muted-foreground text-lg"><?= l('index.api.subheader') ?></p>

                <div class="grid grid-cols-2 gap-4">
                    <?php if(settings()->links->shortener_is_enabled): ?>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-sm"><?= l('api_documentation.links') ?></span>
                        </div>
                    <?php endif ?>

                    <?php if(settings()->links->biolinks_is_enabled ||settings()->links->shortener_is_enabled ||settings()->links->files_is_enabled ||settings()->links->vcards_is_enabled ||settings()->links->events_is_enabled ||settings()->links->static_is_enabled): ?>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-sm"><?= l('api_documentation.statistics') ?></span>
                        </div>
                    <?php endif ?>

                    <?php if(settings()->codes->qr_codes_is_enabled): ?>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-sm"><?= l('qr_codes.title') ?></span>
                        </div>
                    <?php endif ?>

                    <?php if(settings()->links->projects_is_enabled): ?>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-sm"><?= l('projects.title') ?></span>
                        </div>
                    <?php endif ?>

                    <?php if(settings()->links->pixels_is_enabled): ?>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-sm"><?= l('pixels.title') ?></span>
                        </div>
                    <?php endif ?>

                    <?php if(settings()->links->domains_is_enabled): ?>
                        <div class="flex items-center gap-2">
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span class="text-sm"><?= l('domains.title') ?></span>
                        </div>
                    <?php endif ?>
                </div>

                <a href="<?= url('api-documentation') ?>" class="btn btn-outline btn-lg w-full lg:w-auto">
                    <?= l('api_documentation.menu') ?> <i class="fas fa-code ml-2"></i>
                </a>
            </div>

            <div class="card bg-slate-900 text-slate-100 p-6 font-mono text-sm">
                <div class="space-y-1">
                    <div>curl --request POST \</div>
                    <div>--url '<?= SITE_URL ?>api/links' \</div>
                    <div>--header 'Authorization: Bearer <span class="text-primary"<?= is_logged_in() ? ' data-toggle="tooltip" title="' . l('api_documentation.api_key') . '"' : null ?>><?= is_logged_in() ? $this->user->api_key : '{api_key}' ?></span>' \</div>
                    <div>--header 'Content-Type: multipart/form-data' \</div>
                    <div>--form 'url=<span class="text-primary">example</span>' \</div>
                    <div>--form 'location_url=<span class="text-primary"><?= SITE_URL ?></span>' \</div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif ?>

    <style>
        /* hide until words are wrapped to avoid flash */
        .reveal-effect { visibility: hidden; }

        /* base state for each word */
        .reveal-effect-prepared .reveal-effect-word {
            opacity: 0;
            filter: blur(6px);
            transform: translate3d(0, 8px, 0);
            display: inline-block;
            transition: opacity .5s ease, filter .5s ease, transform .5s ease;
        }

        /* animate in when container gets .reveal-effect-in */
        .reveal-effect-prepared.reveal-effect-in .reveal-effect-word {
            opacity: 1;
            filter: blur(0);
            transform: none;
        }
    </style>

    <script defer>
        /* wrap words in a text node while preserving existing HTML */
        const wrap_words_in_text_node = (text_node) => {
            /* split into words + spaces, keep spacing intact */
            const tokens = text_node.textContent.split(/(\s+)/);
            const fragment = document.createDocumentFragment();

            tokens.forEach((token) => {
                if (token.trim().length === 0) {
                    fragment.appendChild(document.createTextNode(token));
                } else {
                    const span_node = document.createElement('span');
                    span_node.className = 'reveal-effect-word';
                    span_node.textContent = token;
                    fragment.appendChild(span_node);
                }
            });

            text_node.parentNode.replaceChild(fragment, text_node);
        };

        /* prepare a container: wrap only pure text nodes, not tags */
        const prepare_reveal_container = (container_node) => {
            /* collect first to avoid live-walking issues while replacing */
            const walker = document.createTreeWalker(
                container_node,
                NodeFilter.SHOW_TEXT,
                { acceptNode: (node) => node.textContent.trim().length ? NodeFilter.FILTER_ACCEPT : NodeFilter.FILTER_REJECT }
            );
            const text_nodes = [];
            while (walker.nextNode()) { text_nodes.push(walker.currentNode); }
            text_nodes.forEach(wrap_words_in_text_node);

            /* add stagger */
            const word_nodes = container_node.querySelectorAll('.reveal-effect-word');
            word_nodes.forEach((word_node, index) => {
                word_node.style.transitionDelay = (index * 40) + 'ms';
            });

            /* mark as prepared and reveal visibility */
            container_node.classList.add('reveal-effect-prepared');
            container_node.style.visibility = 'visible';
        };

        /* set up scroll trigger */
        document.addEventListener('DOMContentLoaded', () => {
            const container_node = document.querySelector('.reveal-effect');
            if (!container_node) { return; }

            /* prepare once (preserves HTML) */
            prepare_reveal_container(container_node);

            /* trigger when in view */
            const on_intersect = (entries, observer) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        /* start the animation */
                        container_node.classList.add('reveal-effect-in');
                        observer.unobserve(container_node);
                    }
                });
            };

            const intersection_observer = new IntersectionObserver(on_intersect, {
                root: null,
                rootMargin: '0px 0px -10% 0px',
                threshold: 0.1
            });

            intersection_observer.observe(container_node);
        });
    </script>
<?php endif ?>


<?php if(settings()->main->display_index_testimonials): ?>
<section class="py-16 bg-primary/5">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-2">
                <?= l('index.testimonials.header') ?> <i class="fas fa-check-circle text-green-500"></i>
            </h2>
        </div>

        <?php
        $language_array = \Altum\Language::get(\Altum\Language::$name);
        if(\Altum\Language::$main_name != \Altum\Language::$name) {
            $language_array = array_merge(\Altum\Language::get(\Altum\Language::$main_name), $language_array);
        }

        $testimonials_language_keys = [];
        foreach ($language_array as $key => $value) {
            if(preg_match('/index\.testimonials\.(\w+)\./', $key, $matches)) {
                $testimonials_language_keys[] = $matches[1];
            }
        }

        $testimonials_language_keys = array_unique($testimonials_language_keys);
        ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <?php foreach($testimonials_language_keys as $key => $value): ?>
                <div class="card p-6 hover:shadow-lg transition-shadow" data-aos="fade-up" data-aos-delay="<?= $key * 100 ?>">
                    <div class="text-center space-y-4">
                        <img src="<?= get_custom_image_if_any('index/testimonial-' . $value . '.webp') ?>" class="w-20 h-20 rounded-full mx-auto object-cover" alt="<?= l('index.testimonials.' . $value . '.name') . ', ' . l('index.testimonials.' . $value . '.attribute') ?>" loading="lazy" />

                        <blockquote class="text-lg italic text-muted-foreground">
                            "<?= l('index.testimonials.' . $value . '.text') ?>"
                        </blockquote>

                        <div>
                            <div class="font-semibold text-lg"><?= l('index.testimonials.' . $value . '.name') ?></div>
                            <div class="text-muted-foreground text-sm"><?= l('index.testimonials.' . $value . '.attribute') ?></div>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif ?>

<?php if(settings()->main->display_index_plans): ?>
<section class="py-16">
    <div id="plans" class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4"><?= l('index.pricing.header') ?></h2>
        </div>

        <?= $this->views['plans'] ?>
    </div>
</section>
<?php endif ?>

<?php if(settings()->main->display_index_faq): ?>
<section class="py-16 bg-muted/30">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold mb-4"><?= l('index.faq.header') ?></h2>
        </div>

        <?php
        $language_array = \Altum\Language::get(\Altum\Language::$name);
        if(\Altum\Language::$main_name != \Altum\Language::$name) {
            $language_array = array_merge(\Altum\Language::get(\Altum\Language::$main_name), $language_array);
        }

        $faq_language_keys = [];
        foreach ($language_array as $key => $value) {
            if(preg_match('/index\.faq\.(\w+)\./', $key, $matches)) {
                $faq_language_keys[] = $matches[1];
            }
        }

        $faq_language_keys = array_unique($faq_language_keys);
        ?>

        <div class="max-w-4xl mx-auto space-y-4">
            <?php foreach($faq_language_keys as $key): ?>
                <div class="card">
                    <div class="p-6">
                        <details class="group">
                            <summary class="flex items-center justify-between cursor-pointer font-semibold text-lg hover:text-primary transition-colors">
                                <span><?= l('index.faq.' . $key . '.question') ?></span>
                                <i class="fas fa-chevron-down transition-transform group-open:rotate-180"></i>
                            </summary>
                            <div class="mt-4 text-muted-foreground">
                                <?= l('index.faq.' . $key . '.answer') ?>
                            </div>
                        </details>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif ?>

<?php if(settings()->users->register_is_enabled): ?>
<section class="py-16 bg-gradient-to-r from-primary to-primary/80 text-primary-foreground">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-8 items-center text-center lg:text-left">
            <div class="space-y-4">
                <h2 class="text-4xl font-bold"><?= l('index.cta.header') ?></h2>
                <p class="text-xl opacity-90"><?= l('index.cta.subheader') ?></p>
            </div>

            <div class="flex justify-center lg:justify-end">
                <?php if(is_logged_in()): ?>
                    <a href="<?= url('dashboard') ?>" class="btn btn-secondary btn-lg">
                        <?= l('dashboard.menu') ?> <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= url('register') ?>" class="btn btn-secondary btn-lg">
                        <?= l('index.cta.register') ?> <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                <?php endif ?>
            </div>
        </div>
    </div>
</section>
<?php endif ?>

<?php if(count($data->blog_posts)): ?>
<section class="py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold">
                <?= sprintf(l('index.blog.header'), '<span class="text-primary">', '</span>') ?>
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <?php foreach($data->blog_posts as $blog_post): ?>
                <div class="card overflow-hidden hover:shadow-lg transition-shadow">
                    <?php if($blog_post->image): ?>
                        <a href="<?= SITE_URL . ($blog_post->language ? \Altum\Language::$active_languages[$blog_post->language] . '/' : null) . 'blog/' . $blog_post->url ?>" aria-label="<?= $blog_post->title ?>">
                            <img src="<?= \Altum\Uploads::get_full_url('blog') . $blog_post->image ?>" class="w-full h-48 object-cover hover:scale-105 transition-transform" alt="<?= $blog_post->image_description ?>" loading="lazy" />
                        </a>
                    <?php endif ?>

                    <div class="p-6">
                        <a href="<?= SITE_URL . ($blog_post->language ? \Altum\Language::$active_languages[$blog_post->language] . '/' : null) . 'blog/' . $blog_post->url ?>">
                            <h3 class="text-xl font-semibold mb-2 hover:text-primary transition-colors line-clamp-2">
                                <?= $blog_post->title ?>
                            </h3>
                        </a>

                        <p class="text-muted-foreground line-clamp-3">
                            <?= $blog_post->description ?>
                        </p>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    </div>
</section>
<?php endif ?>


<?php ob_start() ?>
<link rel="stylesheet" href="<?= ASSETS_FULL_URL . 'css/libraries/aos.min.css?v=' . PRODUCT_CODE ?>">
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>

<?php ob_start() ?>
<script src="<?= ASSETS_FULL_URL . 'js/libraries/aos.min.js?v=' . PRODUCT_CODE ?>"></script>

<script>
    'use strict';

    AOS.init({
        duration: 600
    });
</script>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

<?php ob_start() ?>
<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= settings()->main->title ?>",
        "url": "<?= url() ?>",
    <?php if(settings()->main->{'logo_' . \Altum\ThemeStyle::get()}): ?>
        "logo": "<?= settings()->main->{'logo_' . \Altum\ThemeStyle::get() . '_full_url'} ?>",
        <?php endif ?>
    "slogan": "<?= l('index.header') ?>",
        "contactPoint": {
            "@type": "ContactPoint",
            "url": "<?= url('contact') ?>",
            "contactType": "Contact us"
        }
    }
</script>

<script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": [
            {
                "@type": "ListItem",
                "position": 1,
                "name": "<?= l('index.title') ?>",
                    "item": "<?= url() ?>"
                }
            ]
        }
</script>

<?php if(settings()->main->display_index_faq): ?>
    <?php
    $faqs = [];
    foreach($faq_language_keys as $key) {
        $faqs[] = [
            '@type' => 'Question',
            'name' => l('index.faq.' . $key . '.question'),
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => l('index.faq.' . $key . '.answer'),
            ]
        ];
    }
    ?>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": <?= json_encode($faqs) ?>
        }
    </script>
<?php endif ?>
<?php \Altum\Event::add_content(ob_get_clean(), 'javascript') ?>

<?php ob_start() ?>
    <link href="<?= ASSETS_FULL_URL . 'css/index-custom.css?v=' . PRODUCT_CODE ?>" rel="stylesheet" media="screen,print">
<?php \Altum\Event::add_content(ob_get_clean(), 'head') ?>
