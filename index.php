<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>MSG91 OTP Widget Example</title>
</head>
<body>

<h2>MSG91 OTP Verification</h2>
<div id="message">Waiting for OTP verification...</div>

<script type="text/javascript">
  var configuration = {
    widgetId: "346568696b45343632363537",
    tokenAuth: "263591T5x9D0LgHdZ67f4f68aP1",
    identifier: "919479819774",
    exposeMethods: true,
    success: (data) => {
      console.log('success response', data);

      const accessToken = data.accessToken;
      if (!accessToken) {
        displayMessage('No accessToken received');
        return;
      }

      // Send access token to backend for verification
      fetch('verify-token.php', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({ access_token: accessToken })
      })
      .then(res => res.json())
      .then(resData => {
        console.log('Verification response from server:', resData);
        // Display the whole JSON response nicely formatted
        displayMessage('Verification Response:<br><pre>' + JSON.stringify(resData, null, 2) + '</pre>');
      })
      .catch(error => {
        console.error('Error verifying token:', error);
        displayMessage('Error verifying token: ' + error.message);
      });
    },
    failure: (error) => {
      console.log('failure reason', error);
      displayMessage('OTP widget failure: ' + JSON.stringify(error));
    }
  };

  // Helper to display messages in the div
  function displayMessage(html) {
    document.getElementById('message').innerHTML = html;
  }
</script>

<script 
  type="text/javascript" 
  onload="initSendOTP(configuration)" 
  src="https://verify.msg91.com/otp-provider.js">
</script>

</body>
</html>
