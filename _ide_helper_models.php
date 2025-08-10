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
 * @property string $name
 * @property string|null $address
 * @property int|null $province_id
 * @property int|null $city_id
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
 * @property string $status
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
 * @property int $quotation_id
 * @property string $job_number
 * @property string|null $start_date
 * @property string|null $end_date
 * @property string $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Quotation $quotation
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LabJob whereJobNumber($value)
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
 * @property int $test_method_id
 * @property string $name
 * @property string $unit
 * @property string|null $description
 * @property string $default_price
 * @property string $status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ParameterQuotationItem> $parameterQuotationItem
 * @property-read int|null $parameter_quotation_item_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ParameterTestPackage> $parameterTestPackages
 * @property-read int|null $parameter_test_packages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\QuotationItem> $quotationItems
 * @property-read int|null $quotation_items_count
 * @property-read \App\Models\TestMethod $testMethod
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestPackage> $testPackages
 * @property-read int|null $test_packages_count
 * @method static \Database\Factories\ParameterFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereDefaultPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereTestMethodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Parameter whereUpdatedBy($value)
 */
	class Parameter extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $quotation_item_id
 * @property int $parameter_id
 * @property string|null $parameter_name
 * @property string|null $parameter_unit
 * @property string|null $parameter_default_price
 * @property string|null $parameter_default_test_method_name
 * @property string|null $parameter_description
 * @property string|null $parameter_status
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Parameter $parameter
 * @property-read \App\Models\QuotationItem $quotationItem
 * @method static \Database\Factories\ParameterQuotationItemFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterDefaultPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterDefaultTestMethodName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ParameterQuotationItem whereParameterStatus($value)
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
 * @property int $parameter_id
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Parameter $parameter
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
 * @property int $user_id
 * @property int $company_id
 * @property string $fullname
 * @property string|null $nip
 * @property string|null $phone_number
 * @property string|null $address
 * @property string|null $position
 * @property string|null $certification_details
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quotation> $approvedQuotations
 * @property-read int|null $approved_quotations_count
 * @property-read \App\Models\Company $company
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Quotation> $quotations
 * @property-read int|null $quotations_count
 * @property-read \App\Models\User $user
 * @method static \Database\Factories\PersonelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereCertificationDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereFullname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereNip($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereUpdatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Personel whereUserId($value)
 */
	class Personel extends \Eloquent {}
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
 * @property int $customer_id
 * @property int $personel_id
 * @property string $quotation_name
 * @property string $quotation_number
 * @property string $quotation_date
 * @property string $valid_until_date
 * @property string $discount_percentage
 * @property string $ppn_percentage
 * @property string $pph_percentage
 * @property string $total_amount
 * @property string|null $additional_description
 * @property string $status
 * @property int|null $approved_by_personel_id
 * @property string|null $approved_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Personel|null $approvedByPersonel
 * @property-read \App\Models\Customer $customer
 * @property-read float $total_price
 * @property-read \App\Models\Personel $personel
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereDiscountPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation wherePersonelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation wherePphPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation wherePpnPercentage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereQuotationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereQuotationName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Quotation whereQuotationNumber($value)
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
 * @property string $price
 * @property int $quantity
 * @property string $unit
 * @property string|null $location
 * @property string $group
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read float $item_total
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
 * @property string $name
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\RegulationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Regulation whereUpdatedBy($value)
 */
	class Regulation extends \Eloquent {}
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
 * @property int $sample_type_id
 * @property string $name
 * @property string $environment_type
 * @property string|null $description
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TestPackage> $sampleMatrics
 * @property-read int|null $sample_matrics_count
 * @property-read \App\Models\SampleType $sampleType
 * @method static \Database\Factories\SampleMatricFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereEnvironmentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SampleMatric whereId($value)
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
 * @property int|null $default_term_template_id
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereDefaultTermTemplateId($value)
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Setting whereUpdatedBy($value)
 */
	class Setting extends \Eloquent {}
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
 * @property int $sample_matric_id
 * @property int $regulation_id
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
 * @property-read \App\Models\Regulation $regulation
 * @property-read \App\Models\SampleMatric $sampleMatric
 * @method static \Database\Factories\TestPackageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereRegulationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereSampleMatricId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TestPackage whereUpdatedBy($value)
 */
	class TestPackage extends \Eloquent {}
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
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Customer|null $customer
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Personel|null $personel
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

