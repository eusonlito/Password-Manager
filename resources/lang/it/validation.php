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

    'accepted' => 'L\'attributo :attribute deve essere accettato.',
    'active_url' => 'L\'attributo :attribute non è un URL valido.',
    'after' => 'L\'attributo :attribute Deve essere una data successiva a :date.',
    'after_or_equal' => 'L\'attributo :attribute deve essere una data successiva o uguale a :date.',
    'alpha' => 'L\'attributo :attribute deve contenere solo lettere.',
    'alpha_dash' => 'L\'attributo :attribute deve contenere solo lettere, numeri, trattini e trattini-bassi.',
    'alpha_num' => 'L\'attributo :attribute deve contenere solo lettere e numeri.',
    'array' => 'L\'attributo :attribute deve essere un array.',
    'before' => 'L\'attributo :attribute deve essere una data antecedente a :date.',
    'before_or_equal' => 'L\'attributo :attribute deve essere una data antecedente o uguale a :date.',
    'between' => [
        'numeric' => 'L\'attributo :attribute deve essere compreso tra :min e :max.',
        'file' => 'L\'attributo :attribute deve essere compreso tra :min e :max kilobytes.',
        'string' => 'L\'attributo :attribute deve essere compreso tra :min e :max caratteri.',
        'array' => 'L\'attributo :attribute deve essere compreso tra :min e :max elementi.',
    ],
    'boolean' => 'L\'attributo :attribute deve essere vero o falso.',
    'confirmed' => 'L\'attributo :attribute non è stato confermato.',
    'current_password' => 'La password non è valida.',
    'date' => 'L\'attributo :attribute non è una data valida.',
    'date_equals' => 'L\'attributo :attribute deve essere una data uguale a :date.',
    'date_format' => 'L\'attributo :attribute non rispetta il formato :format.',
    'different' => 'L\'attributo :attribute e :other devono essere diversi.',
    'digits' => 'L\'attributo :attribute deve avere :digits cifre.',
    'digits_between' => 'L\'attributo :attribute deve essere compreso tra :min e :max cifre.',
    'dimensions' => 'L\'attributo :attribute ha una dimensione dell\'immagine non valida.',
    'distinct' => 'L\'attributo :attribute ha un valore duplicato.',
    'email' => 'L\'attributo :attribute deve essere un indirzzo email valido.',
    'ends_with' => 'L\'attributo :attribute deve terminare con uno dei seguenti valori: :values.',
    'exists' => 'L\'attributo :attribute non è valido.',
    'file' => 'L\'attributo :attribute deve essere un file.',
    'filled' => 'L\'attributo :attribute deve avere un valore.',
    'gt' => [
        'numeric' => 'L\'attributo :attribute deve essere più grande di :value.',
        'file' => 'L\'attributo :attribute deve essere più grande di :value kilobytes.',
        'string' => 'L\'attributo :attribute deve essere più lungo di :value caratteri.',
        'array' => 'L\'attributo :attribute deve avere più di :value elementi.',
    ],
    'gte' => [
        'numeric' => 'L\'attributo :attribute deve essere più grande o uguale a :value.',
        'file' => 'L\'attributo :attribute deve essere più grande o uguale a :value kilobytes.',
        'string' => 'L\'attributo :attribute deve essere lungo almeno :value caratteri.',
        'array' => 'L\'attributo :attribute must have :value items or more.',
    ],
    'image' => 'L\'attributo :attribute deve essere un\'immagine.',
    'in' => 'L\'attributo :attribute selezionato non è valido.',
    'in_array' => 'L\'attributo :attribute non esiste in :other.',
    'integer' => 'L\'attributo :attribute deve essere un numero intero.',
    'ip' => 'L\'attributo :attribute deve essere un indirizzo IP valido.',
    'ipv4' => 'L\'attributo :attribute deve essere un indirizzo IPv4 valido.',
    'ipv6' => 'L\'attributo :attribute deve essere un indirizzo IPv6 valido.',
    'json' => 'L\'attributo :attribute deve essere una stringa JSON valida.',
    'lt' => [
        'numeric' => 'L\'attributo :attribute deve essere minore di :value.',
        'file' => 'L\'attributo :attribute deve essere minore di :value kilobytes.',
        'string' => 'L\'attributo :attribute deve essere minore di :value caratteri.',
        'array' => 'L\'attributo :attribute deve avere meno di :value elementi.',
    ],
    'lte' => [
        'numeric' => 'L\'attributo :attribute deve essere minore o uguale di :value.',
        'file' => 'L\'attributo :attribute deve essere minore o uguale di :value kilobytes.',
        'string' => 'L\'attributo :attribute deve contenere un massimo di :value caratteri.',
        'array' => 'L\'attributo :attribute non deve avere più di :value elementi.',
    ],
    'max' => [
        'numeric' => 'L\'attributo :attribute non deve essere maggiore di :max.',
        'file' => 'L\'attributo :attribute non deve essere maggiore di :max kilobytes.',
        'string' => 'L\'attributo :attribute non deve contenere più di :max caratteri.',
        'array' => 'L\'attributo :attribute non deve avere più di :max elementi.',
    ],
    'mimes' => 'L\'attributo :attribute deve essere un file di tipo: :values.',
    'mimetypes' => 'L\'attributo :attribute deve essere un file di tipo: :values.',
    'min' => [
        'numeric' => 'L\'attributo :attribute deve essere almeno :min.',
        'file' => 'L\'attributo :attribute deve essere almeno :min kilobytes.',
        'string' => 'L\'attributo :attribute deve contenere almeno :min caratteri.',
        'array' => 'L\'attributo :attribute deve avere almeno :min elementi.',
    ],
    'multiple_of' => 'L\'attributo :attribute deve essere un multiplo di :value.',
    'not_in' => 'L\'attributo :attribute selezionato non è valido.',
    'not_regex' => 'L\'attributo :attribute non ha un formato valido.',
    'numeric' => 'L\'attributo :attribute deve essere un numero.',
    'password' => 'La password non è corretta.',
    'present' => 'The :attribute deve essere presente.',
    'regex' => 'L\'attributo :attribute ha un formato non valido.',
    'required' => 'L\'attributo :attribute è richiesto..',
    'required_if' => 'L\'attributo :attribute è richiesto quando :other è :value.',
    'required_unless' => 'L\'attributo :attribute è richiesto tranne se :other è in :values.',
    'required_with' => 'L\'attributo :attribute è richiesto quando :values è presente.',
    'required_with_all' => 'L\'attributo :attribute è richiesto quando :values sono presenti.',
    'required_without' => 'L\'attributo :attribute è richiesto quando :values non è presente.',
    'required_without_all' => 'L\'attributo :attribute è richiesto quando non è presente alcun :values.',
    'prohibited' => 'L\'attributo :attribute è proibito.',
    'prohibited_if' => 'L\'attributo :attribute è proibito quando :other è :value.',
    'prohibited_unless' => 'L\'attributo :attribute è proibito tranne se :other è in :values.',
    'same' => 'L\'attributo :attribute e :other devono coincidere.',
    'size' => [
        'numeric' => 'L\'attributo :attribute deve essere :size.',
        'file' => 'L\'attributo :attribute deve essere :size kilobytes.',
        'string' => 'L\'attributo :attribute deve contenere :size charatteri.',
        'array' => 'L\'attributo :attribute deve contenere :size elementi.',
    ],
    'starts_with' => 'L\'attributo :attribute deve iniziare con uno dei seguenti valori: :values.',
    'string' => 'L\'attributo :attribute deve essere una stringa.',
    'timezone' => 'L\'attributo :attribute deve essere una valida timezone.',
    'unique' => 'L\'attributo :attribute è già stato utilizzato.',
    'uploaded' => 'Impossibile caricare l\'attributo :attribute.',
    'url' => 'L\'attributo :attribute deve essere un URL valido.',
    'uuid' => 'L\'attributo :attribute deve essere un UUID valido.',

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
            'rule-name' => 'custom-message',
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
