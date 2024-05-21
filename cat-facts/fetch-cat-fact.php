<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Function to fetch cat facts from the API
 *
 * @return array
 * @throws GuzzleException
 */
function fetchCatFacts(): array {
    $client = new Client();
    $response =
        $client->request('GET',
            'https://cat-fact.herokuapp.com/facts');

    if ($response->getStatusCode() === 200) {
        $body = $response->getBody();
        return json_decode($body, true);
    } else {
        return [];
    }
}

/**
 * Function to display cat facts
 *
 * @param array $facts
 */
function displayCatFacts(array $facts) {
    if (empty($facts)) {
        echo "No cat facts available.\n";
        return;
    }

    echo "Random Cat Fact:\n";
    echo "======================================================\n";
    $randomFact = $facts[array_rand($facts)];
    echo $randomFact['text'] . "\n";
    echo "======================================================\n";

}


try {
    $catFacts = fetchCatFacts();
    if (!empty($catFacts)) {
        displayCatFacts($catFacts);
    } else {
        echo "Failed to fetch cat facts. Please try again later.\n";
    }
} catch (GuzzleException $e) {
    echo "An error occurred: " . $e->getMessage() . "\n";
}
