<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.2.1/firebase.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->

<script>
    // Your web app's Firebase configuration
    var firebaseConfig = {
        apiKey: "AIzaSyAPAVsbioP6pgfFi2Qy06I5LXF5uyWhmJ4",
        authDomain: "tdh-srs.firebaseapp.com",
        projectId: "tdh-srs",
        storageBucket: "tdh-srs.appspot.com",
        messagingSenderId: "409081614015",
        appId: "1:409081614015:web:86a8e77c46a498a255800a"
    };
    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();
    // Get registration token. Initially this makes a network call, once retrieved
    // subsequent calls to getToken will return from cache.
    messaging.getToken({ vapidKey: 'BJ7_ExaGHexL81AZQN5J6UWmm5L-Z9tEYJbrXjMs1tLlh4zo2wdXRptHI2FI6TfcOVm6LVSUYpAOHk6I8aR0uRY' }).then((currentToken) => {
        if (currentToken) {
            // Send the token to your server and update the UI if necessary
            // ...
            console.log(currentToken);
        } else {
            // Show permission request UI
            console.log('No registration token available. Request permission to generate one.');
            // ...
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
        // ...
    });
</script>