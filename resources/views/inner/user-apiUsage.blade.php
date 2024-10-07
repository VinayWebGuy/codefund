@extends('inner.layouts.main')
@section('title', 'How to use the API')
@section('user-api', 'active')
@section('content')

<div class="container">
    <h3>How to Use the API</h3>
    <ol>
        <li><strong>Create an API key:</strong> First, generate your API key by navigating to your <a class="link" href="{{url('main/user/api')}}">API Manager</a>.</li>
        <li><strong>Base URL:</strong> Use the following as the base URL for all API requests: 
            <pre><code class="language-html">{{AppInfo('domain_name')}}</code></pre>
        </li>
        <li><strong>Endpoints:</strong> Concatenate the required endpoint with the base URL. Example for fetching wallet balance:
            <pre><code class="language-html">{{AppInfo('domain_name')}}/v1/check-balance</code></pre>
        </li>
        <li><strong>Headers:</strong> Pass your API key in the headers as <code>key</code>. If the API is created with extra security, pass the secure header as <code>secure_header</code> in the headers.
        </li>
    </ol>

    <h4>Example API Requests</h4>

    <h5>1. cURL Request</h5>
    <pre><code class="language-bash">
curl -X GET '{{AppInfo('domain_name')}}/v1/check-balance' \
-H 'token_key: YOUR_API_KEY' \
-H 'secure_header: YOUR_SECURE_KEY' \ # if have
-H 'Content-Type: application/json'
    </code></pre>

    <h5>2. Axios Request (JavaScript)</h5>
    <pre><code class="language-javascript">
const axios = require('axios');

axios.get('{{AppInfo('domain_name')}}/v1/check-balance', {
    headers: {
        'token_key': 'YOUR_API_KEY',
        'secure_header': 'YOUR_SECURE_KEY', // if have
        'Content-Type': 'application/json'
    }
}).then(response => {
    console.log(response.data);
}).catch(error => {
    console.error(error);
});
    </code></pre>

    <h5>3. Fetch API (JavaScript)</h5>
    <pre><code class="language-javascript">
fetch('{{AppInfo('domain_name')}}/v1/check-balance', {
    method: 'GET',
    headers: {
        'token_key': 'YOUR_API_KEY',
        'secure_header': 'YOUR_SECURE_KEY', // if have
        'Content-Type': 'application/json'
    }
}).then(response => response.json())
  .then(data => console.log(data))
  .catch(error => console.error(error));
    </code></pre>

    <h5>4. Python (Requests Library)</h5>
    <pre><code class="language-python">
import requests

url = '{{AppInfo('domain_name')}}/v1/check-balance'
headers = {
    'token_key': 'YOUR_API_KEY',
    'secure_header': 'YOUR_SECURE_KEY', # if have
    'Content-Type': 'application/json'
}

response = requests.get(url, headers=headers)
print(response.json())
    </code></pre>

    <h5>5. PHP (cURL)</h5>
    <pre><code class="language-php">
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => '{{AppInfo('domain_name')}}/v1/check-balance',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => array(
    'token_key: YOUR_API_KEY',
    'secure_header: YOUR_SECURE_KEY', # if have
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
echo $response;
    </code></pre>

    <p>Remember to replace <code>YOUR_API_KEY</code> and <code>YOUR_SECURE_KEY</code> with the actual keys you generated from <a class="link" href="{{url('main/user/api')}}">API Manager</a>.</p>
</div>

@endsection
