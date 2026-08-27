<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * @property int $id
 * @property int|null $province_id
 * @property string $name
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Customer> $customer
 * @property-read int|null $customer_count
 * @property-read \App\Models\Province|null $province
 * @method static \Database\Factories\CityFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|City whereUpdatedBy($value)
 */
	class City extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $province_id
 * @property int|null $city_id
 * @property string $name
 * @property string|null $address
 * @property string|null $postal_code
 * @property string|null $phone
 * @property string|null $email
 * @property string|null $website
 * @property string|null $npwp
 * @property int $is_main_company
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City|null $city
 * @property-read mixed $active_setting
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Personel> $personnels
 * @property-read int|null $personnels_count
 * @property-read \App\Models\Province|null $province
 * @property-write mixed $mail_password
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Setting> $settings
 * @property-read int|null $settings_count
 * @method static \Database\Factories\CompanyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereIsMainCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereNpwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereWebsite($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property int|null $province_id
 * @property int|null $city_id
 * @property int $customer_type_id
 * @property string $name
 * @property string|null $full_address
 * @property string|null $postal_code
 * @property string $contact_person_name
 * @property string|null $contact_person_title
 * @property string $contact_phone_number
 * @property string|null $contact_email
 * @property string|null $npwp
 * @property string $registration_date
 * @property int $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\CustomerType $customerType
 * @property-read \App\Models\Province|null $province
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\CustomerFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereContactEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereContactPersonName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereContactPersonTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereContactPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereCustomerTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereFullAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereNpwp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereProvinceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereRegistrationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Customer whereUserId($value)
 */
	class Customer extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Customer> $customer
 * @property-read int|null $customer_count
 * @method static \Database\Factories\CustomerTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CustomerType whereUpdatedBy($value)
 */
	class CustomerType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $lab_job_id
 * @property string $code
 * @property \Illuminate\Support\Carbon $date
 * @property \Illuminate\Support\Carbon $due_date
 * @property string $subtotal
 * @property string $discount_percentage
 * @property string $discount_amount
 * @property string $dpp_amount
 * @property string $ppn_percentage
 * @property string $ppn_amount
 * @property string $pph_percentage
 * @property string $pph_amount
 * @property string $total_amount
 * @property string $net_amount
 * @property int $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Enums\InvoiceStatusEnum $status_enum
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvoiceItem> $invoiceItems
 * @property-read int|null $invoice_items_count
 * @property-read \App\Models\LabJob $labJob
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @method static \Database\Factories\InvoiceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDiscountPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDppAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereLabJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereNetAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice wherePphAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice wherePphPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice wherePpnAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice wherePpnPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Invoice whereUpdatedBy($value)
 */
	class Invoice extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $invoice_id
 * @property string|null $source_type
 * @property int|null $source_id
 * @property string $description
 * @property string $quantity
 * @property string $price
 * @property float $subtotal
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Invoice $invoice
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $source
 * @method static \Database\Factories\InvoiceItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereSourceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereSourceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InvoiceItem whereUpdatedBy($value)
 */
	class InvoiceItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $quotation_id
 * @property string $code
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float $total_price
 * @property-read \App\Models\Invoice|null $invoice
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LabJobItem> $labJobItems
 * @property-read int|null $lab_job_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LabJobPersonel> $labJobPersonels
 * @property-read int|null $lab_job_personels_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Personel> $personels
 * @property-read int|null $personels_count
 * @property-read \App\Models\Quotation $quotation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sample> $samples
 * @property-read int|null $samples_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereQuotationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereUpdatedBy($value)
 */
	class LabJob extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property string|null $description_code
 * @property int $lab_job_id
 * @property int|null $quotation_item_id
 * @property int|null $test_package_id
 * @property int|null $regulation_id
 * @property string $description
 * @property string|null $regulation_name
 * @property int $quantity
 * @property string $unit
 * @property string $price
 * @property string|null $location
 * @property string $group
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float $item_total
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvoiceItem> $invoiceItems
 * @property-read int|null $invoice_items_count
 * @property-read \App\Models\LabJob $labJob
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ParameterLabJobItem> $parameterLabJobItems
 * @property-read int|null $parameter_lab_job_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Parameter> $parameters
 * @property-read int|null $parameters_count
 * @property-read \App\Models\QuotationItem|null $quotationItem
 * @property-read \App\Models\Regulation|null $regulation
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sample> $samples
 * @property-read int|null $samples_count
 * @property-read \App\Models\TestPackage|null $testPackage
 * @method static \Database\Factories\LabJobItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereDescriptionCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereLabJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereQuotationItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereRegulationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereRegulationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereTestPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobItem whereUpdatedBy($value)
 */
	class LabJobItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $lab_job_id
 * @property int $personel_id
 * @property string $position
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LabJob $labJob
 * @property-read \App\Models\Personel $personel
 * @method static \Database\Factories\LabJobPersonelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobPersonel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobPersonel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobPersonel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobPersonel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobPersonel whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobPersonel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobPersonel whereLabJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobPersonel wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobPersonel wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobPersonel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJobPersonel whereUpdatedBy($value)
 */
	class LabJobPersonel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $code
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Parameter> $parameters
 * @property-read int|null $parameters_count
 * @method static \Database\Factories\ParamFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Param newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Param newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Param query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Param whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Param whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Param whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Param whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Param whereUpdatedBy($value)
 */
	class Param extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $test_method_id
 * @property string|null $code
 * @property string $long_name
 * @property string|null $long_name_standard_notes
 * @property string|null $unit
 * @property string|null $description
 * @property string $default_price
 * @property int $status
 * @property int|null $tested_time
 * @property string|null $standard_notes
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LabJobItem> $labJobItems
 * @property-read int|null $lab_job_items_count
 * @property-read \App\Models\Param|null $param
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ParameterLabJobItem> $parameterLabJobItems
 * @property-read int|null $parameter_lab_job_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ParameterQuotationItem> $parameterQuotationItems
 * @property-read int|null $parameter_quotation_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ParameterTestPackage> $parameterTestPackages
 * @property-read int|null $parameter_test_packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Personel> $personels
 * @property-read int|null $personels_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuotationItem> $quotationItems
 * @property-read int|null $quotation_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SpecialisasiParameters> $specialisasiParameters
 * @property-read int|null $specialisasi_parameters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Specialization> $specializations
 * @property-read int|null $specializations_count
 * @property-read \App\Models\TestMethod|null $testMethod
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestPackage> $testPackages
 * @property-read int|null $test_packages_count
 * @method static \Database\Factories\ParameterFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereDefaultPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereLongNameStandardNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereStandardNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereTestMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereTestedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereUpdatedBy($value)
 */
	class Parameter extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $lab_job_item_id
 * @property int $parameter_id
 * @property string|null $parameter_code
 * @property string|null $parameter_unit
 * @property string|null $parameter_price
 * @property string|null $parameter_test_method_name
 * @property string|null $parameter_standard_notes
 * @property string|null $parameter_description
 * @property string|null $parameter_status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LabJobItem $labJobItem
 * @property-read \App\Models\Parameter $parameter
 * @method static \Database\Factories\ParameterLabJobItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereLabJobItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereParameterCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereParameterDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereParameterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereParameterPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereParameterStandardNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereParameterStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereParameterTestMethodName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereParameterUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterLabJobItem whereUpdatedBy($value)
 */
	class ParameterLabJobItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $quotation_item_id
 * @property int|null $parameter_id
 * @property string|null $parameter_code
 * @property string|null $parameter_unit
 * @property string|null $parameter_price
 * @property string|null $parameter_test_method_name
 * @property string|null $parameter_standard_notes
 * @property string|null $parameter_description
 * @property string|null $parameter_status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Parameter|null $parameter
 * @property-read \App\Models\QuotationItem $quotationItem
 * @method static \Database\Factories\ParameterQuotationItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterStandardNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterTestMethodName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereQuotationItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereUpdatedBy($value)
 */
	class ParameterQuotationItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $test_package_id
 * @property int|null $parameter_id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Parameter|null $parameter
 * @property-read \App\Models\TestPackage $testPackage
 * @method static \Database\Factories\ParameterTestPackageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterTestPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterTestPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterTestPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterTestPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterTestPackage whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterTestPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterTestPackage whereParameterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterTestPackage whereTestPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterTestPackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterTestPackage whereUpdatedBy($value)
 */
	class ParameterTestPackage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property int $invoice_id
 * @property string $date
 * @property string $amount_paid
 * @property string $payment_method
 * @property string|null $reference_number
 * @property string|null $notes
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property string|null $attachment_path
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Invoice $invoice
 * @method static \Database\Factories\PaymentFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAmountPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereAttachmentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Payment whereUpdatedBy($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $user_id
 * @property int|null $company_id
 * @property int|null $position_id
 * @property string|null $nip
 * @property string $fullname
 * @property string|null $phone_number
 * @property string|null $address
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quotation> $approvedQuotations
 * @property-read int|null $approved_quotations_count
 * @property-read \App\Models\Company|null $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LabJobPersonel> $labJobPersonels
 * @property-read int|null $lab_job_personels_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LabJob> $labJobs
 * @property-read int|null $lab_jobs_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Parameter> $parameters
 * @property-read int|null $parameters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestResultApproval> $personel
 * @property-read int|null $personel_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonelSpecialization> $personelSpecializations
 * @property-read int|null $personel_specializations_count
 * @property-read \App\Models\Position|null $position
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quotation> $quotations
 * @property-read int|null $quotations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sample> $samplesCollected
 * @property-read int|null $samples_collected_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sample> $samplesReceived
 * @property-read int|null $samples_received_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Specialization> $specializations
 * @property-read int|null $specializations_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\PersonelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel wherePositionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereUserId($value)
 */
	class Personel extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $personel_id
 * @property int $specialization_id
 * @property string|null $file_path
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel $personel
 * @property-read \App\Models\Specialization $specialization
 * @method static \Database\Factories\PersonelSpecializationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonelSpecialization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonelSpecialization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonelSpecialization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonelSpecialization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonelSpecialization whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonelSpecialization whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonelSpecialization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonelSpecialization wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonelSpecialization whereSpecializationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonelSpecialization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PersonelSpecialization whereUpdatedBy($value)
 */
	class PersonelSpecialization extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Personel> $personels
 * @property-read int|null $personels_count
 * @method static \Database\Factories\PositionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Position whereUpdatedBy($value)
 */
	class Position extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\City> $cities
 * @property-read int|null $cities_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Customer> $customer
 * @property-read int|null $customer_count
 * @method static \Database\Factories\ProvinceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Province whereUpdatedBy($value)
 */
	class Province extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $request_id
 * @property int|null $customer_id
 * @property int|null $personel_id
 * @property string $name
 * @property string $code
 * @property string $date
 * @property string $valid_until_date
 * @property string $discount_percentage
 * @property string $ppn_percentage
 * @property string $pph_percentage
 * @property string $total_amount
 * @property string|null $additional_description
 * @property int $status
 * @property int|null $approved_by_personel_id
 * @property string|null $approved_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel|null $approvedByPersonel
 * @property-read \App\Models\Customer|null $customer
 * @property-read float $total_price
 * @property-read \App\Models\LabJob|null $labJob
 * @property-read \App\Models\Personel|null $personel
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuotationItem> $quotationItems
 * @property-read int|null $quotation_items_count
 * @property-read \App\Models\Request|null $request
 * @method static \Database\Factories\QuotationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereAdditionalDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereApprovedByPersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereDiscountPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation wherePphPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation wherePpnPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereValidUntilDate($value)
 */
	class Quotation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $quotation_id
 * @property int|null $test_package_id
 * @property int|null $regulation_id
 * @property string $description
 * @property string|null $regulation_name
 * @property int $quantity
 * @property string $unit
 * @property string $price
 * @property string|null $location
 * @property string $group
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float $item_total
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InvoiceItem> $invoiceItems
 * @property-read int|null $invoice_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ParameterQuotationItem> $parameterQuotationItems
 * @property-read int|null $parameter_quotation_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Parameter> $parameters
 * @property-read int|null $parameters_count
 * @property-read \App\Models\Quotation $quotation
 * @property-read \App\Models\Regulation|null $regulation
 * @property-read \App\Models\TestPackage|null $testPackage
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereQuotationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereRegulationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereRegulationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereTestPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|QuotationItem whereUpdatedBy($value)
 */
	class QuotationItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $regulation_type_id
 * @property string $name
 * @property string|null $long_name
 * @property int $is_active
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RegulationType|null $regulationType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestPackage> $testPackages
 * @property-read int|null $test_packages_count
 * @method static \Database\Factories\RegulationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereRegulationTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereUpdatedBy($value)
 */
	class Regulation extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $long_name
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Regulation> $regulations
 * @property-read int|null $regulations_count
 * @method static \Database\Factories\RegulationTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegulationType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegulationType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegulationType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegulationType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegulationType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegulationType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegulationType whereLongName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegulationType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegulationType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RegulationType whereUpdatedBy($value)
 */
	class RegulationType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $customer_id
 * @property int $lab_job_id
 * @property string $request_number
 * @property string $request_name
 * @property string $request_date
 * @property string|null $testing_activity_type
 * @property string|null $request_notes
 * @property string $request_status
 * @property string $status_update_timestamp
 * @property string|null $approved_by_user_id
 * @property string|null $approved_at
 * @property string $ppn_percentage
 * @property string $pph_percentage
 * @property string $total_amount
 * @property string|null $term_agreements
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quotation> $quotations
 * @property-read int|null $quotations_count
 * @method static \Database\Factories\RequestFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereApprovedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereLabJobId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request wherePphPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request wherePpnPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereRequestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereRequestName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereRequestNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereRequestNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereRequestStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereStatusUpdateTimestamp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereTermAgreements($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereTestingActivityType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Request whereUpdatedBy($value)
 */
	class Request extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $request_id
 * @property int $test_package_id
 * @property string $description
 * @property string $regulation_name
 * @property int $quantity
 * @property string $unit
 * @property string $price
 * @property string $location
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\RequestItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereRegulationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereTestPackageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RequestItem whereUpdatedBy($value)
 */
	class RequestItem extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $guard_name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereGuardName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role withoutPermission($permissions)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $code
 * @property int $lab_job_item_id
 * @property int|null $collected_by_personel_id
 * @property int|null $received_by_personel_id
 * @property \Illuminate\Support\Carbon|null $collection_date
 * @property \Illuminate\Support\Carbon|null $collection_time
 * @property string|null $collection_location_desc
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $preservation_method
 * @property string|null $collection_notes
 * @property \Illuminate\Support\Carbon|null $received_date
 * @property \Illuminate\Support\Carbon|null $received_time
 * @property string|null $received_condition_notes
 * @property string|null $container_type
 * @property int|null $container_quantity
 * @property string|null $sample_volume
 * @property \Illuminate\Support\Carbon|null $analyzed_start_date
 * @property \Illuminate\Support\Carbon|null $analyzed_end_date
 * @property int $collection_type
 * @property int $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel|null $collectedByPersonel
 * @property-read \App\Models\LabJobItem $labJobItem
 * @property-read \App\Models\Personel|null $receivedByPersonel
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SampleHistory> $sampleHistories
 * @property-read int|null $sample_histories_count
 * @property-read \App\Models\SampleMatric|null $sampleMatric
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestResult> $testResults
 * @property-read int|null $test_results_count
 * @method static \Database\Factories\SampleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereAnalyzedEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereAnalyzedStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereCollectedByPersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereCollectionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereCollectionLocationDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereCollectionNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereCollectionTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereCollectionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereContainerQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereContainerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereLabJobItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample wherePreservationMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereReceivedByPersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereReceivedConditionNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereReceivedDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereReceivedTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereSampleVolume($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Sample whereUpdatedBy($value)
 */
	class Sample extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $personel_id
 * @property int $sample_id
 * @property int $action
 * @property string|null $changes
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel $personel
 * @property-read \App\Models\Sample $sample
 * @method static \Database\Factories\SampleHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory whereChanges($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory whereSampleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleHistory whereUpdatedBy($value)
 */
	class SampleHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property string $code
 * @property int|null $sample_type_id
 * @property string $name
 * @property string|null $code_name
 * @property int $environment_type
 * @property string|null $description
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestPackage> $sampleMatrics
 * @property-read int|null $sample_matrics_count
 * @property-read \App\Models\SampleType|null $sampleType
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Sample> $samples
 * @property-read int|null $samples_count
 * @method static \Database\Factories\SampleMatricFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereCodeName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereEnvironmentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereSampleTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereUpdatedBy($value)
 */
	class SampleMatric extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\SampleTypeFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleType whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleType whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleType whereUpdatedBy($value)
 */
	class SampleType extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $company_id
 * @property string|null $letterhead_path
 * @property int|null $default_quotation_expiry_days
 * @property int|null $term_template_id
 * @property string|null $mail_mailer
 * @property string|null $mail_host
 * @property string|null $mail_port
 * @property string|null $mail_username
 * @property string|null $mail_password
 * @property string|null $mail_encryption
 * @property string|null $mail_from_address
 * @property string|null $mail_from_name
 * @property int $is_active
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\TermTemplate|null $termTemplate
 * @method static \Database\Factories\SettingFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereDefaultQuotationExpiryDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereLetterheadPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereMailEncryption($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereMailFromAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereMailFromName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereMailHost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereMailMailer($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereMailPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereMailPort($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereMailUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereTermTemplateId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedBy($value)
 */
	class Setting extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $specialization_id
 * @property int $parameter_id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Parameter|null $parameter
 * @property-read \App\Models\Specialization|null $specialization
 * @method static \Database\Factories\SpecialisasiParametersFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialisasiParameters newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialisasiParameters newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialisasiParameters query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialisasiParameters whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialisasiParameters whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialisasiParameters whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialisasiParameters whereParameterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialisasiParameters whereSpecializationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialisasiParameters whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpecialisasiParameters whereUpdatedBy($value)
 */
	class SpecialisasiParameters extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Parameter> $parameters
 * @property-read int|null $parameters_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PersonelSpecialization> $personelSpecializations
 * @property-read int|null $personel_specializations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Personel> $personels
 * @property-read int|null $personels_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SpecialisasiParameters> $specialisasiParameters
 * @property-read int|null $specialisasi_parameters_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialization whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialization whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Specialization whereUpdatedBy($value)
 */
	class Specialization extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int $is_active
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Setting> $settings
 * @property-read int|null $settings_count
 * @method static \Database\Factories\TermTemplateFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TermTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TermTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TermTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TermTemplate whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TermTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TermTemplate whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TermTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TermTemplate whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TermTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TermTemplate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TermTemplate whereUpdatedBy($value)
 */
	class TermTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string|null $name
 * @property string|null $description
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Parameter> $parameter
 * @property-read int|null $parameter_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestResult> $testResults
 * @property-read int|null $test_results_count
 * @method static \Database\Factories\TestMethodFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestMethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestMethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestMethod query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestMethod whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestMethod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestMethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestMethod whereUpdatedBy($value)
 */
	class TestMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $code
 * @property int|null $regulation_id
 * @property string|null $description
 * @property string $price
 * @property int $is_active
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ParameterTestPackage> $parameterTestPackages
 * @property-read int|null $parameter_test_packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Parameter> $parameters
 * @property-read int|null $parameters_count
 * @property-read \App\Models\Regulation|null $regulation
 * @property-read \App\Models\SampleMatric|null $sampleMatric
 * @method static \Database\Factories\TestPackageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereRegulationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereUpdatedBy($value)
 */
	class TestPackage extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $sample_id
 * @property int|null $parameter_id
 * @property int|null $test_method_id
 * @property int|null $analyst_personel_id
 * @property int|null $validator_personel_id
 * @property string|null $tested_value
 * @property string|null $unit
 * @property string|null $test_date
 * @property string|null $test_notes
 * @property string|null $standard_notes_ref
 * @property string|null $comment
 * @property int $status
 * @property int $revision_count
 * @property int|null $evaluation_status
 * @property string|null $validation_date
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel|null $analystPersonel
 * @property-read \App\Models\Parameter|null $parameter
 * @property-read \App\Models\Sample $sample
 * @property-read \App\Models\TestMethod|null $testMethod
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestResultApproval> $testResultApprovals
 * @property-read int|null $test_result_approvals_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestResultHistory> $testResultHistories
 * @property-read int|null $test_result_histories_count
 * @property-read \App\Models\Personel|null $validatorPersonel
 * @method static \Database\Factories\TestResultFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult visibleForUser(\App\Models\User $user)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereAnalystPersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereEvaluationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereParameterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereRevisionCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereSampleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereStandardNotesRef($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereTestDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereTestMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereTestNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereTestedValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereValidationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResult whereValidatorPersonelId($value)
 */
	class TestResult extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $test_result_id
 * @property int|null $personel_id
 * @property int $approval_level
 * @property \App\Models\Enums\TestResultApprovalStatusEnum $status
 * @property string|null $note
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel|null $personel
 * @property-read \App\Models\TestResult $testResult
 * @method static \Database\Factories\TestResultApprovalFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval whereApprovalLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval whereTestResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultApproval whereUpdatedBy($value)
 */
	class TestResultApproval extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $personel_id
 * @property int $test_result_id
 * @property \App\Models\Enums\TestResultHistoryActionEnum $action
 * @property array<array-key, mixed>|null $changes
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel $personel
 * @property-read \App\Models\TestResult $testResult
 * @method static \Database\Factories\TestResultHistoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory whereChanges($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory whereTestResultId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestResultHistory whereUpdatedBy($value)
 */
	class TestResultHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property int|null $current_team_id
 * @property string|null $profile_photo_path
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $company_id
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Personel|null $personel
 * @property-read mixed $personel_id
 * @property-read string $profile_photo_url
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCurrentTeamId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent implements \Filament\Models\Contracts\FilamentUser {}
}

