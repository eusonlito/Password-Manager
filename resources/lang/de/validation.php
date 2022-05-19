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

    'accepted' => 'Das Feld :attribute muss akzeptiert werden.',
    'active_url' => 'Das Feld :attribute ist keine gueltige URL.',
    'after' => 'Das Feld :attribute muss ein Datum nach :date sein.',
    'after_or_equal' => 'Der Wert :attribute muss gleich oder nach :date sein.',
    'alpha' => 'Der Wert :attribute darf nur Buchstaben enthalten.',
    'alpha_dash' => 'Der Wert :attribute darf nur Buchstaben, Zahlen, Schraegstriche und Unterstriche enthalten.',
    'alpha_num' => 'Der Wert :attribute darf nur Buchstaben und Zahlen enthalten.',
    'array' => 'Der Wert :attribute muss ein Array sein.',
    'before' => 'Der Wert :attribute muss ein Datum vor :date sein.',
    'before_or_equal' => 'Der Wert :attribute muss ein Datum vor oder gleich :date sein.',
    'between' => [
        'numeric' => 'Der Wert :attribute muss zwischen :min und :max sein.',
        'file' => 'Der Wert :attribute muss zwischen :min und :max kilobytes liegen.',
        'string' => 'Der Wert :attribute muss zwischen :min und :max Zeichen sein.',
        'array' => 'Der Wert :attribute muss zwischen :min und :max Objekten sein.',
    ],
    'boolean' => 'Der Wert :attribute muss wahr oder falsch sein.',
    'confirmed' => 'Der Wert :attribute stimm nicht ueberein.',
    'current_password' => 'Das Password ist inkorrekt.',
    'date' => 'Der Wert :attribute ist kein gueltiges Datum.',
    'date_equals' => 'Der Wert :attribute muss ein Datum gleich :date sein.',
    'date_format' => 'Der Wert :attribute entspricht nicht dem Format :format.',
    'different' => 'Der Wert :attribute und :other muss unterschiedlich sein.',
    'digits' => 'Der Wert :attribute muss mind. :digits Ziffern enthalten.',
    'digits_between' => 'Der Wert :attribute muss zwischen :min und :max Ziffrn enthalten.',
    'dimensions' => 'Der Wert :attribute hat die falschen Bildmasse.',
    'distinct' => 'Das Feld :attribute hat doppelte EintrΓ¤ge.',
    'email' => 'Der Wert :attribute muss eine gueltige Emailadresse sein.',
    'ends_with' => 'Der Wert :attribute muss mit einem der folgenden Zeichen enden: :values.',
    'exists' => 'Das gewaehlte :attribute ist ungueltig.',
    'file' => 'Der Wert :attribute muss eine Datei sein.',
    'filled' => 'Das Feld :attribute darf nicht leer sein.',
    'gt' => [
        'numeric' => 'Der Wert :attribute muss groesser sein als :value.',
        'file' => 'Der Wert :attribute muss groesser sein als :value kilobytes.',
        'string' => 'Der Wert :attribute muss mind. :value Zeichen enthalten.',
        'array' => 'Der Wert :attribute muss mehr als :value Objekte enthalten.',
    ],
    'gte' => [
        'numeric' => 'Der Wert :attribute muss grΓ¶sser oder gleich :value sein.',
        'file' => 'Der Wert :attribute muss groesser oder gleich :value kilobytes sein.',
        'string' => 'Der Wert :attribute muss groesser oder gleich :value Zeichen enthalten.',
        'array' => 'Der Wert :attribute muss mind. :value Objekte enthalten.',
    ],
    'image' => 'Der Wert :attribute muss ein Bild sein.',
    'in' => 'Das gewaehlte :attribute ist ungueltig.',
    'in_array' => 'Das Feld :attribute existiert nicht in :other.',
    'integer' => 'Der Wert :attribute muss eine Zahl sein.',
    'ip' => 'Der Wert :attribute muss eine gueltige IP-Adresse sein.',
    'ipv4' => 'Der Wert :attribute muss eine gueltige valid IPv4 Adresse sein.',
    'ipv6' => 'Der Wert :attribute muss eine gueltige IPv6 Adresse sein.',
    'json' => 'Der Wert :attribute muss ein gueltige JSON String sein.',
    'lt' => [
        'numeric' => 'Der Wert :attribute muss kleiner sein als :value.',
        'file' => 'Der Wert :attribute muss kleiner sein als :value kilobytes.',
        'string' => 'Der Wert :attribute muss kleiner sein als :value Zeichen.',
        'array' => 'Der Wert :attribute muss kleiner sein als :value Objekte.',
    ],
    'lte' => [
        'numeric' => 'Der Wert :attribute muss kleiner oder gleich :value sein.',
        'file' => 'Das :Attribut muss kleiner oder gleich :value Kilobyte sein.',
        'string' => 'Das :attribute muss kleiner oder gleich :value Zeichen sein.',
        'array' => 'Das :attribute darf nicht mehr als :value Elemente haben.',
    ],
    'maximal' => [
        'numeric' => 'Das :Attribut darf nicht grφίer als :max sein.',
        'file' => 'Das :Attribut darf nicht grφίer als :max Kilobyte sein.',
        'string' => 'Das :Attribut darf nicht grφίer als :max Zeichen sein.',
        'array' => 'Das :attribute darf nicht mehr als :max Elemente haben.',
    ],
    'mimes' => 'Das :attribute muss eine Datei des Typs: :values ??sein.',
    'mimetypes' => 'Das :attribute muss eine Datei des Typs: :values ??sein.',
    'min' => [
        'numeric' => 'Das :Attribut muss mindestens :min sein.',
        'file' => 'Das :Attribut muss mindestens :min Kilobyte groί sein.',
        'string' => 'Das :Attribut muss mindestens :min Zeichen lang sein.',
        'array' => 'Das :attribute muss mindestens :min Elemente haben.',
    ],
    'multiple_of' => 'Das :attribute muss ein Vielfaches von :value sein.',
    'not_in' => 'Das ausgewδhlte :Attribut ist ungόltig.',
    'not_regex' => 'Das :Attribut-Format ist ungόltig.',
    'numeric' => 'Das :Attribut muss eine Zahl sein.',
    'password' => 'Das Passwort ist falsch.',
    'present' => 'Das Feld :attribute muss vorhanden sein.',
    'regex' => 'Das :Attribut-Format ist ungόltig.',
    'required' => 'Das Feld :attribute ist erforderlich.',
    'required_if' => 'Das Feld :attribute ist erforderlich, wenn :other :value ist.',
    'required_unless' => 'Das Feld :attribute ist erforderlich, es sei denn, :other ist in :values ??enthalten.',
    'required_with' => 'Das Feld :attribute ist erforderlich, wenn :values ??vorhanden ist.',
    'required_with_all' => 'Das Feld :attribute ist erforderlich, wenn :values ??vorhanden sind.',
    'required_without' => 'Das Feld :attribute ist erforderlich, wenn :values ??nicht vorhanden ist.',
    'required_without_all' => 'Das Feld :attribute ist erforderlich, wenn keiner der :values ??vorhanden ist.',
    'prohibited' => 'Das Feld :attribute ist verboten.',
    'prohibited_if' => 'Das Feld :attribute ist verboten, wenn :other :value ist.',
    'prohibited_unless' => 'Das Feld :attribute ist verboten, es sei denn, :other ist in :values ??enthalten.',
    'same' => 'Das :attribute und :other mόssen όbereinstimmen.',
    'Grφίe' => [
        'numeric' => 'Das :attribute muss :size sein.',
        'file' => 'Das :attribute muss :size kilobytes sein.',
        'string' => 'Das :Attribut muss :size Zeichen sein.',
        'array' => 'Das :attribute muss :size-Elemente enthalten.',
    ],
    'starts_with' => 'Das :attribute muss mit einem der folgenden Werte beginnen: :values.',
    'string' => 'Das :attribute muss ein String sein.',
    'timezone' => 'Das :Attribut muss eine gόltige Zeitzone sein.',
    'unique' => 'Das :Attribut wurde bereits vergeben.',
    'uploaded' => 'Das :Attribut konnte nicht hochgeladen werden.',
    'url' => 'Das :Attribut muss eine gόltige URL sein.',
    'uuid' => 'Das :Attribut muss eine gόltige UUID sein.',

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
