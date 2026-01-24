<?php

/**
 * Countries with their provinces/states
 * Format: 'COUNTRY_CODE' => ['name' => 'Country Name', 'provinces' => ['CODE' => 'Name']]
 */

return [
    'US' => [
        'name' => 'United States',
        'provinces' => [
            'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas',
            'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware',
            'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho',
            'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas',
            'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland',
            'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi',
            'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada',
            'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York',
            'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma',
            'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina',
            'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah',
            'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia',
            'WI' => 'Wisconsin', 'WY' => 'Wyoming'
        ]
    ],
    'CA' => [
        'name' => 'Canada',
        'provinces' => [
            'AB' => 'Alberta', 'BC' => 'British Columbia', 'MB' => 'Manitoba',
            'NB' => 'New Brunswick', 'NL' => 'Newfoundland and Labrador', 'NS' => 'Nova Scotia',
            'ON' => 'Ontario', 'PE' => 'Prince Edward Island', 'QC' => 'Quebec',
            'SK' => 'Saskatchewan', 'NT' => 'Northwest Territories', 'NU' => 'Nunavut',
            'YT' => 'Yukon'
        ]
    ],
    'PK' => [
        'name' => 'Pakistan',
        'provinces' => [
            'PB' => 'Punjab', 'SD' => 'Sindh', 'KP' => 'Khyber Pakhtunkhwa',
            'BA' => 'Balochistan', 'GB' => 'Gilgit-Baltistan', 'AJK' => 'Azad Jammu and Kashmir',
            'IS' => 'Islamabad Capital Territory'
        ]
    ],
    'IN' => [
        'name' => 'India',
        'provinces' => [
            'AP' => 'Andhra Pradesh', 'AR' => 'Arunachal Pradesh', 'AS' => 'Assam', 'BR' => 'Bihar',
            'CT' => 'Chhattisgarh', 'GA' => 'Goa', 'GJ' => 'Gujarat', 'HR' => 'Haryana',
            'HP' => 'Himachal Pradesh', 'JK' => 'Jammu and Kashmir', 'JH' => 'Jharkhand', 'KA' => 'Karnataka',
            'KL' => 'Kerala', 'MP' => 'Madhya Pradesh', 'MH' => 'Maharashtra', 'MN' => 'Manipur',
            'ML' => 'Meghalaya', 'MZ' => 'Mizoram', 'NL' => 'Nagaland', 'OR' => 'Odisha',
            'PB' => 'Punjab', 'RJ' => 'Rajasthan', 'SK' => 'Sikkim', 'TN' => 'Tamil Nadu',
            'TG' => 'Telangana', 'TR' => 'Tripura', 'UP' => 'Uttar Pradesh', 'UT' => 'Uttarakhand',
            'WB' => 'West Bengal', 'AN' => 'Andaman and Nicobar Islands', 'CH' => 'Chandigarh',
            'DN' => 'Dadra and Nagar Haveli', 'DD' => 'Daman and Diu', 'DL' => 'Delhi',
            'LD' => 'Lakshadweep', 'PY' => 'Puducherry'
        ]
    ],
    'AU' => [
        'name' => 'Australia',
        'provinces' => [
            'NSW' => 'New South Wales', 'QLD' => 'Queensland', 'SA' => 'South Australia',
            'TAS' => 'Tasmania', 'VIC' => 'Victoria', 'WA' => 'Western Australia',
            'ACT' => 'Australian Capital Territory', 'NT' => 'Northern Territory'
        ]
    ],
    'GB' => [
        'name' => 'United Kingdom',
        'provinces' => [
            'ENG' => 'England', 'SCT' => 'Scotland', 'WLS' => 'Wales', 'NIR' => 'Northern Ireland'
        ]
    ],
    'AE' => [
        'name' => 'UAE',
        'provinces' => [
            'AZ' => 'Abu Dhabi', 'AJ' => 'Ajman', 'DU' => 'Dubai', 'FU' => 'Fujairah',
            'RK' => 'Ras al-Khaimah', 'SH' => 'Sharjah', 'UQ' => 'Umm al-Quwain'
        ]
    ],
    'SA' => [
        'name' => 'Saudi Arabia',
        'provinces' => [
            'RI' => 'Riyadh', 'MK' => 'Makkah', 'MD' => 'Madinah', 'QS' => 'Qassim',
            'EA' => 'Eastern Province', 'AS' => 'Asir', 'TB' => 'Tabuk', 'HA' => 'Hail',
            'NB' => 'Northern Borders', 'JZ' => 'Jazan', 'NJ' => 'Najran', 'BA' => 'Al Bahah', 'JF' => 'Al Jouf'
        ]
    ],
    'MY' => [
        'name' => 'Malaysia',
        'provinces' => [
            'JHR' => 'Johor', 'KDH' => 'Kedah', 'KTN' => 'Kelantan', 'KUL' => 'Kuala Lumpur',
            'LBN' => 'Labuan', 'MLK' => 'Malacca', 'NSN' => 'Negeri Sembilan', 'PHG' => 'Pahang',
            'PNG' => 'Penang', 'PRK' => 'Perak', 'PLS' => 'Perlis', 'PJY' => 'Putrajaya',
            'SBH' => 'Sabah', 'SGR' => 'Selangor', 'SWK' => 'Sarawak', 'TRG' => 'Terengganu'
        ]
    ],
    'CN' => [
        'name' => 'China',
        'provinces' => [
            'BJ' => 'Beijing', 'TJ' => 'Tianjin', 'SH' => 'Shanghai', 'CQ' => 'Chongqing',
            'HE' => 'Hebei', 'SX' => 'Shanxi', 'NM' => 'Inner Mongolia', 'LN' => 'Liaoning',
            'JL' => 'Jilin', 'HL' => 'Heilongjiang', 'JS' => 'Jiangsu', 'ZJ' => 'Zhejiang',
            'AH' => 'Anhui', 'FJ' => 'Fujian', 'JX' => 'Jiangxi', 'SD' => 'Shandong',
            'HA' => 'Henan', 'HB' => 'Hubei', 'HN' => 'Hunan', 'GD' => 'Guangdong',
            'GX' => 'Guangxi', 'HI' => 'Hainan', 'SC' => 'Sichuan', 'GZ' => 'Guizhou',
            'YN' => 'Yunnan', 'XZ' => 'Tibet', 'SN' => 'Shaanxi', 'GS' => 'Gansu',
            'QH' => 'Qinghai', 'NX' => 'Ningxia', 'XJ' => 'Xinjiang'
        ]
    ],
    'MX' => [
        'name' => 'Mexico',
        'provinces' => [
            'AGU' => 'Aguascalientes', 'BCN' => 'Baja California', 'BCS' => 'Baja California Sur',
            'CAM' => 'Campeche', 'CHP' => 'Chiapas', 'CHH' => 'Chihuahua', 'COA' => 'Coahuila',
            'COL' => 'Colima', 'DUR' => 'Durango', 'GUA' => 'Guanajuato', 'GRO' => 'Guerrero',
            'HID' => 'Hidalgo', 'JAL' => 'Jalisco', 'MEX' => 'Mexico State', 'MIC' => 'Michoacán',
            'MOR' => 'Morelos', 'NAY' => 'Nayarit', 'NLE' => 'Nuevo León', 'OAX' => 'Oaxaca',
            'PUE' => 'Puebla', 'QUE' => 'Querétaro', 'ROO' => 'Quintana Roo', 'SLP' => 'San Luis Potosí',
            'SIN' => 'Sinaloa', 'SON' => 'Sonora', 'TAB' => 'Tabasco', 'TAM' => 'Tamaulipas',
            'TLA' => 'Tlaxcala', 'VER' => 'Veracruz', 'YUC' => 'Yucatán', 'ZAC' => 'Zacatecas',
            'CMX' => 'Mexico City'
        ]
    ],
    'BR' => [
        'name' => 'Brazil',
        'provinces' => [
            'AC' => 'Acre', 'AL' => 'Alagoas', 'AP' => 'Amapá', 'AM' => 'Amazonas',
            'BA' => 'Bahia', 'CE' => 'Ceará', 'DF' => 'Federal District', 'ES' => 'Espírito Santo',
            'GO' => 'Goiás', 'MA' => 'Maranhão', 'MT' => 'Mato Grosso', 'MS' => 'Mato Grosso do Sul',
            'MG' => 'Minas Gerais', 'PA' => 'Pará', 'PB' => 'Paraíba', 'PR' => 'Paraná',
            'PE' => 'Pernambuco', 'PI' => 'Piauí', 'RJ' => 'Rio de Janeiro', 'RN' => 'Rio Grande do Norte',
            'RS' => 'Rio Grande do Sul', 'RO' => 'Rondônia', 'RR' => 'Roraima', 'SC' => 'Santa Catarina',
            'SP' => 'São Paulo', 'SE' => 'Sergipe', 'TO' => 'Tocantins'
        ]
    ],
    // Countries without provinces (will hide province dropdown)
    'AF' => ['name' => 'Afghanistan', 'provinces' => []],
    'AL' => ['name' => 'Albania', 'provinces' => []],
    'DZ' => ['name' => 'Algeria', 'provinces' => []],
    'AR' => ['name' => 'Argentina', 'provinces' => []],
    'AT' => ['name' => 'Austria', 'provinces' => []],
    'BD' => ['name' => 'Bangladesh', 'provinces' => []],
    'BE' => ['name' => 'Belgium', 'provinces' => []],
    'CO' => ['name' => 'Colombia', 'provinces' => []],
    'DK' => ['name' => 'Denmark', 'provinces' => []],
    'EG' => ['name' => 'Egypt', 'provinces' => []],
    'FR' => ['name' => 'France', 'provinces' => []],
    'DE' => ['name' => 'Germany', 'provinces' => []],
    'GR' => ['name' => 'Greece', 'provinces' => []],
    'HK' => ['name' => 'Hong Kong', 'provinces' => []],
    'ID' => ['name' => 'Indonesia', 'provinces' => []],
    'IE' => ['name' => 'Ireland', 'provinces' => []],
    'IT' => ['name' => 'Italy', 'provinces' => []],
    'JP' => ['name' => 'Japan', 'provinces' => []],
    'KE' => ['name' => 'Kenya', 'provinces' => []],
    'NL' => ['name' => 'Netherlands', 'provinces' => []],
    'NZ' => ['name' => 'New Zealand', 'provinces' => []],
    'NG' => ['name' => 'Nigeria', 'provinces' => []],
    'NO' => ['name' => 'Norway', 'provinces' => []],
    'PH' => ['name' => 'Philippines', 'provinces' => []],
    'PL' => ['name' => 'Poland', 'provinces' => []],
    'PT' => ['name' => 'Portugal', 'provinces' => []],
    'RU' => ['name' => 'Russia', 'provinces' => []],
    'SG' => ['name' => 'Singapore', 'provinces' => []],
    'ZA' => ['name' => 'South Africa', 'provinces' => []],
    'KR' => ['name' => 'South Korea', 'provinces' => []],
    'ES' => ['name' => 'Spain', 'provinces' => []],
    'LK' => ['name' => 'Sri Lanka', 'provinces' => []],
    'SE' => ['name' => 'Sweden', 'provinces' => []],
    'CH' => ['name' => 'Switzerland', 'provinces' => []],
    'TH' => ['name' => 'Thailand', 'provinces' => []],
    'TR' => ['name' => 'Turkey', 'provinces' => []],
    'VN' => ['name' => 'Vietnam', 'provinces' => []],
];
