<?php

header("Content-Type: text/plain");
$result = "";
$apiKey = "";

if(!isset($_REQUEST["q"])){
    exit("not posted");
}

$input = "Give me the solution for the question below by following these rules:
1. Write the code in Java & Python Both.
2. Name the main class `Main`.
3. Use standard input and output with `Scanner` and `System.out`.
4. Do not include comments in the code.
5. Use meaningful names in English for functions and variables.
6. Only use the `java.util.*` package and built-in Java functions; no additional libraries are allowed.
7. Search online for the problem statement and check previous submissions for reference.
8. Return the code as plain text, without any language identifier.
9. Ensure the code's output is tested with the input and output relevant to the question.
10. at the end of response, add the python code. python result will not maintain rules 2 to rules 9. python code must must be super easy. before starting python code, add a separator with dashes line to separate python code and java code.

question: ```".$_REQUEST["q"]."```";


$url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;
$data = [
    "contents" => [
        [
            "parts" => [
                [
                    "text" => "$input"
                ]
            ]
        ]
    ]
];

$curl = curl_init($url);
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => [
        "Content-Type: application/json"
    ]
]);
$response = curl_exec($curl);
$statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

curl_close($curl);

$responseDecoded = json_decode($response, true);

if(isset($responseDecoded['candidates'][0]['content']['parts'][0]['text'])){
    echo $responseDecoded['candidates'][0]['content']['parts'][0]['text'];
}else{
    // echo "error";
    echo $response;
}
