function calcPasswordHash(pid, password) {
    var encoder = new TextEncoder();
    var pidBuffer = new Uint32Array([pid]).buffer;
    var pidBytes = new Uint8Array(pidBuffer);
    var staticBytes = new Uint8Array([2, 101, 67, 70]);
    var passwordBytes = encoder.encode(password);
    var data = new Uint8Array(pidBytes.length + staticBytes.length + passwordBytes.length);

    data.set(pidBytes);
    data.set(staticBytes, pidBytes.length);
    data.set(passwordBytes, pidBytes.length + staticBytes.length);

    return crypto.subtle.digest('SHA-256', data)
        .then(hashBuffer => {
            const hashArray = Array.from(new Uint8Array(hashBuffer));
            const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
            return hashHex;
        });
}
