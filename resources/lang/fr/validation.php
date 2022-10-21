<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => ':attribute doit être accepté.',
    'active_url' => ':attribute n\'est pas une URL valide.',
    'after' => 'La date d\':attribute doit être ultérieure à :date.',
    'after_or_equal' => ':attribute doit être ultérieur ou égal à :date.',
    'alpha' => ':attribute ne peut contenir que des lettres.',
    'alpha_dash' => ':attribute ne peut contenir que des lettres, nombres, tirets et caractères soulignés.',
    'alpha_num' => ':attribute ne peut contenir que des lettres et des nombres.',
    'array' => ':attribute doit être un tableau.',
    'before' => ':attribute doit être une date antérieure à :date.',
    'before_or_equal' => ':attribute doit être une date antérieure ou égale à or equal to :date.',
    'between' => [
        'numeric' => ':attribute doit être entre :min et :max.',
        'file' => ':attribute doit être entre :min et :max kilooctets.',
        'string' => ':attribute doit contenir entre :min et :max caratères.',
        'array' => ':attribute doit contenir entre :min et :max objets.',
    ],
    'boolean' => 'Le champ :attribute doit être vrai ou faux.',
    'confirmed' => 'La confirmation d\':attribute ne correspond pas.',
    'current_password' => 'Le mot de passe est incorrect.',
    'date' => ':attribute ne contient pas de date valide.',
    'date_equals' => ':attribute doit être une date égale à :date.',
    'date_format' => ':attribute ne correspond pas au format :format.',
    'different' => ':attribute et :other doivent être différents.',
    'digits' => ':attribute doit correcpondre à :digits chiffres.',
    'digits_between' => ':attribute doit se situer entre :min et :max chiffres.',
    'dimensions' => 'Les dimensions de l\'image :attribute sont invalides.',
    'distinct' => 'La valeur du champ :attribute est un doublon.',
    'email' => ':attribute doit correspondre à une adresse email valide.',
    'ends_with' => ':attribute doit se terminer par une des valeurs suivantes: :values.',
    'exists' => ':attribute est invalide.',
    'file' => ':attribute doit être un fichier.',
    'filled' => 'Le champ :attribute doit avoir une valeur.',
    'gt' => [
        'numeric' => ':attribute doit avoir une valeur supérieure à :value.',
        'file' => ':attribute doit être plus grand que :value kilooctets.',
        'string' => ':attribute doit ^tre supérieur à :value caractères.',
        'array' => ':attribute doit avoir plus que :value objets.',
    ],
    'gte' => [
        'numeric' => ':attribute doit être plus grand ou égal à :value.',
        'file' => ':attribute doit être supérieur ou égal à :value kilooctets.',
        'string' => ':attribute doit être plus grand ou égal à :value caractères.',
        'array' => ':attribute doit avoir :value ou plus objets.',
    ],
    'image' => ':attribute doit être une image.',
    'in' => ':attribute est invalide.',
    'in_array' => 'Le champ :attribute n\'existe pas dans :other.',
    'integer' => ':attribute doit être un entier.',
    'ip' => ':attribute doit contenir une adresse IP valide.',
    'ipv4' => ':attribute doit contenir une adresse IPV4 valide.',
    'ipv6' => ':attribute doit contenir une adresse IPV6 valide.',
    'json' => ':attribute doit contenir une chaîne JSON valide.',
    'lt' => [
        'numeric' => ':attribute doit être inférieur à :value.',
        'file' => ':attribute doit être inférieur à :value kilooctets.',
        'string' => ':attribute doit être inférieur à :value caractères.',
        'array' => ':attribute doit contenir moins de :value objets.',
    ],
    'lte' => [
        'numeric' => ':attribute doit être inférieur ou égal à :value.',
        'file' => ':attribute doit être inférieur ou égal à :value kilooctets.',
        'string' => ':attribute doit être inférieur ou égal à :value caractères.',
        'array' => ':attribute ne doitpas avoir plus de :value objets.',
    ],
    'max' => [
        'numeric' => ':attribute ne peut être supérieur à :max.',
        'file' => ':attribute ne peut être supérieur à :max kilooctets.',
        'string' => ':attribute ne peut être supérieur à :max caractères.',
        'array' => ':attribute ne peut contenir plus de :max objets.',
    ],
    'mimes' => ':attribute doit être un fichier de type :values.',
    'mimetypes' => ':attribute doit être un fichier de type :values.',
    'min' => [
        'numeric' => ':attribute doit être au moins :min.',
        'file' => ':attribute doit être d\au moins :min kilooctets.',
        'string' => ':attribute doit être d\'au moins :min caractères.',
        'array' => ':attribute doit contenir au moins :min objets.',
    ],
    'multiple_of' => ':attribute doit être un multiple de :value.',
    'not_in' => 'Le choix :attribute est invalide.',
    'not_regex' => 'Le format de :attribute est invalide.',
    'numeric' => ':attribute doit être un nombre.',
    'password' => 'Le mot de passe est incorrect.',
    'present' => 'Le champ :attribute doit être présent.',
    'regex' => 'Le format de :attribute est invalide.',
    'required' => 'Le champ :attribute est obligatoire.',
    'required_if' => 'TLe champ :attribute est obligatoire whand :other est :value.',
    'required_unless' => 'Le champ :attribute est obligatoire à moins que :other ne corresponde à :values.',
    'required_with' => 'Le champ :attribute est obligatoire quand :values est présent.',
    'required_with_all' => 'Le champ :attribute est obligatoire quand :values est présent.',
    'required_without' => 'Le champ :attribute est obligatoire quand :values n\'est pas présent.',
    'required_without_all' => 'Le champ :attribute est oblogatoire quand aucune des valeurs :values n\'est présente.',
    'prohibited' => 'Le champ :attribute estinterdit.',
    'prohibited_if' => 'Le champ :attribute est interdit quand :other correspond à :value.',
    'prohibited_unless' => 'Le champ :attribute est interdit à moins que :other ne se trouve dans :values.',
    'same' => ':attribute et :other doivent correspondre.',
    'size' => [
        'numeric' => ':attribute doit être :size.',
        'file' => 'La taille d\':attribute doit être de :size kiloctets.',
        'string' => ':attribute doit correspondre à :size caractères.',
        'array' => ':attribute doit contenir :size objets.',
    ],
    'starts_with' => ':attribute doit commencer par une des valeurs suivantes: :values.',
    'string' => ':attribute doit être une chaîne de caractères.',
    'timezone' => ':attribute doit être un fuseau horaire valide.',
    'unique' => ':attribute a déjà été pris.',
    'uploaded' => ':attribute n\'a pu être téléversé.',
    'url' => ':attribute doit être une URL valide.',
    'uuid' => ':attribute doit avoir une UUID valide.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'sage personnalisé',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
