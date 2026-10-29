<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tabel Konfigurasi Section Modular Multi-Halaman
        Schema::create('cms_page_sections', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('page_code', 40)->comment('home, profile, academic, student_affairs, facilities, achievements, ppdb, contact');
            $table->string('section_key', 50)->comment('hero_slider, headmaster_welcome, highlights_metrics, etc.');
            $table->string('badge_title', 60)->nullable();
            $table->string('title', 150);
            $table->string('subtitle', 255)->nullable();
            $table->boolean('is_visible')->default(true);
            $table->unsignedTinyInteger('sort_order')->default(1);
            $table->json('metadata_json')->nullable();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['page_code', 'section_key'], 'uq_page_section');
            $table->index(['page_code', 'is_visible', 'sort_order'], 'idx_page_visibility_order');
        });

        // 2. Tabel Banner Slider & Hero Multi-Halaman
        Schema::create('cms_banners', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('placement', 40)->default('home_hero')->comment('home_hero, profile_hero, academic_hero, student_hero, facilities_hero, ppdb_hero, contact_hero, cta_bottom, popup_modal');
            $table->string('badge_text', 60)->nullable();
            $table->string('title', 160);
            $table->string('subtitle', 255);
            $table->string('cta_primary_text', 50)->nullable()->default('Daftar Sekarang');
            $table->string('cta_primary_url', 255)->nullable()->default('/ppdb');
            $table->string('cta_secondary_text', 50)->nullable()->default('Pelajari Selengkapnya');
            $table->string('cta_secondary_url', 255)->nullable()->default('/profil');
            $table->unsignedInteger('media_asset_id')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->unsignedTinyInteger('sort_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['placement', 'is_active', 'sort_order'], 'idx_banner_placement_active');
            $table->foreign('media_asset_id', 'fk_banner_media')->references('id')->on('sys_media_assets')->nullOnDelete();
        });

        // 3. Tabel Fakta Cepat, Metrik & Keunggulan
        Schema::create('cms_key_highlights', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('placement_target', 40)->default('home_pilar');
            $table->string('icon_name', 50)->default('school');
            $table->string('metric_value', 30);
            $table->string('title', 100);
            $table->string('description', 255);
            $table->string('badge_color', 30)->default('primary');
            $table->string('link_url', 255)->nullable();
            $table->unsignedTinyInteger('sort_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['placement_target', 'is_active', 'sort_order'], 'idx_highlight_target_active');
        });

        // 4. Tabel Testimoni Multi-Kategori & Multi-Halaman
        Schema::create('cms_testimonials', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('person_name', 100);
            $table->enum('person_category', ['orang_tua', 'alumni', 'komite', 'tokoh_masyarakat', 'siswa'])->default('orang_tua');
            $table->string('role_title', 120);
            $table->text('testimonial_text');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->unsignedInteger('avatar_asset_id')->nullable();
            $table->string('placement', 30)->default('all');
            $table->boolean('is_featured')->default(false);
            $table->unsignedTinyInteger('sort_order')->default(1);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['placement', 'is_active', 'is_featured', 'sort_order'], 'idx_testimonial_placement');
            $table->foreign('avatar_asset_id', 'fk_testi_avatar')->references('id')->on('sys_media_assets')->nullOnDelete();
        });

        // 5. Tabel Pengumuman Terjadwal & Alert Bar
        Schema::create('cms_announcements', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('title', 160);
            $table->text('content');
            $table->enum('announcement_type', ['info', 'warning', 'success', 'urgent'])->default('info');
            $table->string('placement_target', 40)->default('global_topbar');
            $table->string('cta_text', 50)->nullable();
            $table->string('cta_url', 255)->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['placement_target', 'is_active', 'start_date', 'end_date'], 'idx_announcement_schedule');
        });

        // 6. Ekstensi Kolom Sambutan & Media Sosial pada mst_school_profile
        if (Schema::hasTable('mst_school_profile')) {
            Schema::table('mst_school_profile', function (Blueprint $table) {
                $table->string('headmaster_welcome_quote', 255)->nullable()->after('headmaster_nip');
                $table->mediumText('headmaster_welcome_text')->nullable()->after('headmaster_welcome_quote');
                $table->unsignedInteger('headmaster_photo_asset_id')->nullable()->after('headmaster_welcome_text');
                $table->string('social_facebook', 200)->nullable()->after('postal_code');
                $table->string('social_instagram', 200)->nullable()->after('social_facebook');
                $table->string('social_youtube', 200)->nullable()->after('social_instagram');
                $table->text('maps_embed_url')->nullable()->after('social_youtube');
                $table->string('operating_hours', 100)->default('Senin - Jumat: 07.00 - 14.30 WIB')->after('maps_embed_url');

                $table->foreign('headmaster_photo_asset_id', 'fk_profile_kepsek_photo')->references('id')->on('sys_media_assets')->nullOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('mst_school_profile')) {
            Schema::table('mst_school_profile', function (Blueprint $table) {
                $table->dropForeign('fk_profile_kepsek_photo');
                $table->dropColumn([
                    'headmaster_welcome_quote',
                    'headmaster_welcome_text',
                    'headmaster_photo_asset_id',
                    'social_facebook',
                    'social_instagram',
                    'social_youtube',
                    'maps_embed_url',
                    'operating_hours',
                ]);
            });
        }

        Schema::dropIfExists('cms_announcements');
        Schema::dropIfExists('cms_testimonials');
        Schema::dropIfExists('cms_key_highlights');
        Schema::dropIfExists('cms_banners');
        Schema::dropIfExists('cms_page_sections');
    }
};
