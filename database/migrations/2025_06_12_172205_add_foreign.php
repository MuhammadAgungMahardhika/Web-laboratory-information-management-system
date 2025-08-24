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
        Schema::table('customers', function (Blueprint $table) {
            $table->foreign('user_id', 'fk_customers_user')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('customer_type_id', 'fk_customers_customer_type')
                ->references('id')
                ->on('customer_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('province_id', 'fk_customers_province')
                ->references('id')
                ->on('provinces')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('city_id', 'fk_customers_city')
                ->references('id')
                ->on('cities')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
        Schema::table('cities', function (Blueprint $table) {
            $table->foreign('province_id', 'fk_cities_province')
                ->references('id')
                ->on('provinces')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
        Schema::table('personels', function (Blueprint $table) {
            $table->foreign('user_id', 'fk_personels_user')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('company_id', 'fk_personels_company')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('position_id', 'fk_personels_position')
                ->references('id')
                ->on('positions')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::table('sample_matrics', function (Blueprint $table) {
            $table->foreign('sample_type_id', 'fk_sample_matrics_sample_type')
                ->references('id')
                ->on('sample_types')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        // sample

        Schema::table('samples', function (Blueprint $table) {
            $table->foreign('lab_job_item_id', 'fk_samples_lab_job_item')
                ->references('id')
                ->on('lab_job_items')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('collected_by_personel_id', 'fk_samples_collected_by_personel')
                ->references('id')
                ->on('personels')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('received_by_personel_id', 'fk_samples_received_by_personel')
                ->references('id')
                ->on('personels')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });


        Schema::table('parameters', function (Blueprint $table) {
            $table->foreign('test_method_id', 'fk_parameters_test_method')
                ->references('id')
                ->on('test_methods')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
        Schema::table('test_packages', function (Blueprint $table) {
            $table->foreign('sample_matric_id', 'fk_test_packages_sample_matric')
                ->references('id')
                ->on('sample_matrics')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::table('parameter_test_packages', function (Blueprint $table) {
            $table->foreign('test_package_id', 'fk_parameter_test_packages_test_packages')
                ->references('id')
                ->on('test_packages')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('parameter_id', 'fk_parameter_test_packages_parameters')
                ->references('id')
                ->on('parameters')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        // labjob
        Schema::table('lab_jobs', function (Blueprint $table) {
            $table->foreign('quotation_id', 'fk_lab_jobs_quotation')
                ->references('id')
                ->on('quotations')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
        Schema::table('lab_job_items', function (Blueprint $table) {
            $table->foreign('lab_job_id', 'fk_lab_job_items_lab_jobs')
                ->references('id')
                ->on('lab_jobs')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('test_package_id', 'fk_lab_job_items_test_packages')
                ->references('id')
                ->on('test_packages')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('regulation_id', 'fk_lab_job_items_regulations')
                ->references('id')
                ->on('regulations')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::table('parameter_lab_job_items', function (Blueprint $table) {
            $table->foreign('lab_job_item_id', 'fk_parameter_lab_job_items_lab_job_items')
                ->references('id')
                ->on('lab_job_items')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('parameter_id', 'fk_parameter_lab_job_items_parameters')
                ->references('id')
                ->on('parameters')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::table('lab_job_personels', function (Blueprint $table) {
            $table->foreign('lab_job_id', 'fk_lab_job_personel_lab_jobs')
                ->references('id')
                ->on('lab_jobs')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('personel_id', 'fk_lab_job_personel_personels')
                ->references('id')
                ->on('personels')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        // akhir labjob
        Schema::table('requests', function (Blueprint $table) {
            $table->foreign('customer_id', 'fk_requests_customer')
                ->references('id')
                ->on('customers')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('lab_job_id', 'fk_requests_lab_job')
                ->references('id')
                ->on('lab_jobs')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::table('quotations', function (Blueprint $table) {
            $table->foreign('request_id', 'fk_quotations_requests')
                ->references('id')
                ->on('requests')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('customer_id', 'fk_quotations_customer')
                ->references('id')
                ->on('customers')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('personel_id', 'fk_quotations_personel')
                ->references('id')
                ->on('personels')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('approved_by_personel_id', 'fk_quotations_approved_by_personel')
                ->references('id')
                ->on('personels')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
        Schema::table('quotation_items', function (Blueprint $table) {
            $table->foreign('quotation_id', 'fk_quotation_items_quotations')
                ->references('id')
                ->on('quotations')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('test_package_id', 'fk_quotation_items_test_packages')
                ->references('id')
                ->on('test_packages')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('regulation_id', 'fk_quotation_items_regulations')
                ->references('id')
                ->on('regulations')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::table('parameter_quotation_items', function (Blueprint $table) {
            $table->foreign('quotation_item_id', 'fk_parameter_quotation_items_quotation_items')
                ->references('id')
                ->on('quotation_items')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('parameter_id', 'fk_parameter_quotation_items_parameters')
                ->references('id')
                ->on('parameters')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->foreign('province_id', 'fk_companies_province')
                ->references('id')
                ->on('provinces')
                ->onUpdate('cascade')
                ->onDelete('set null');
            $table->foreign('city_id', 'fk_companies_city')
                ->references('id')
                ->on('cities')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->foreign('company_id', 'fk_settings_company')
                ->references('id')
                ->on('companies')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('term_template_id', 'fk_settings_term_template')
                ->references('id')
                ->on('term_templates')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });

        Schema::table('test_results', function (Blueprint $table) {
            $table->foreign('sample_id', 'fk_test_results_sample')
                ->references('id')
                ->on('samples')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('parameter_id', 'fk_test_results_parameter')
                ->references('id')
                ->on('parameters')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('test_method_id', 'fk_test_results_test_method')
                ->references('id')
                ->on('test_methods')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('analyst_personel_id', 'fk_test_results_analyst_personel')
                ->references('id')
                ->on('personels')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('validator_personel_id', 'fk_test_results_validator_personel')
                ->references('id')
                ->on('personels')
                ->onUpdate('cascade')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
