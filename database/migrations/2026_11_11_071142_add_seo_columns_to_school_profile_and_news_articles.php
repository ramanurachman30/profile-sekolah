<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('mst_school_profile')) {
            Schema::table('mst_school_profile', function (Blueprint $table): void {
                if (! Schema::hasColumn('mst_school_profile', 'meta_title')) {
                    $table->string('meta_title', 160)->nullable()->after('operating_hours');
                }
                if (! Schema::hasColumn('mst_school_profile', 'meta_description')) {
                    $table->string('meta_description', 255)->nullable()->after('meta_title');
                }
                if (! Schema::hasColumn('mst_school_profile', 'meta_keywords')) {
                    $table->string('meta_keywords', 255)->nullable()->after('meta_description');
                }
                if (! Schema::hasColumn('mst_school_profile', 'og_image_asset_id')) {
                    $table->unsignedInteger('og_image_asset_id')->nullable()->after('meta_keywords');
                    $table->foreign('og_image_asset_id', 'fk_profile_og_image')
                        ->references('id')
                        ->on('sys_media_assets')
                        ->nullOnDelete();
                }
            });

            DB::table('mst_school_profile')
                ->whereNull('meta_title')
                ->update([
                    'meta_title' => 'SDN Cikereteg 01 - Cerdas, Berakhlak Mulia & Berkarakter | Kurikulum Merdeka SD',
                    'meta_description' => 'Website resmi SDN Cikereteg 01, Kec. Caringin, Kab. Bogor. Sekolah Dasar Negeri ramah anak dengan Kurikulum Merdeka, pembiasaan karakter luhur 5S, dan lingkungan belajar asri.',
                    'meta_keywords' => 'SDN Cikereteg 01, SD Negeri Caringin Bogor, Sekolah Dasar Terbaik Bogor, Kurikulum Merdeka SD, PPDB SD Online Bogor, Sekolah Ramah Anak',
                ]);
        }

        if (Schema::hasTable('trn_news_articles')) {
            Schema::table('trn_news_articles', function (Blueprint $table): void {
                if (! Schema::hasColumn('trn_news_articles', 'meta_title')) {
                    $table->string('meta_title', 160)->nullable()->after('summary');
                }
                if (! Schema::hasColumn('trn_news_articles', 'meta_description')) {
                    $table->string('meta_description', 255)->nullable()->after('meta_title');
                }
                if (! Schema::hasColumn('trn_news_articles', 'meta_keywords')) {
                    $table->string('meta_keywords', 255)->nullable()->after('meta_description');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('trn_news_articles')) {
            Schema::table('trn_news_articles', function (Blueprint $table): void {
                $columns = array_filter(
                    ['meta_title', 'meta_description', 'meta_keywords'],
                    fn (string $col): bool => Schema::hasColumn('trn_news_articles', $col)
                );

                if ($columns !== []) {
                    $table->dropColumn($columns);
                }
            });
        }

        if (Schema::hasTable('mst_school_profile')) {
            Schema::table('mst_school_profile', function (Blueprint $table): void {
                if (Schema::hasColumn('mst_school_profile', 'og_image_asset_id')) {
                    $table->dropForeign('fk_profile_og_image');
                }

                $columns = array_filter(
                    ['meta_title', 'meta_description', 'meta_keywords', 'og_image_asset_id'],
                    fn (string $col): bool => Schema::hasColumn('mst_school_profile', $col)
                );

                if ($columns !== []) {
                    $table->dropColumn($columns);
                }
            });
        }
    }
};
