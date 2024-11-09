function fetchGajiPokok(karyawanId) {
    if (karyawanId) {
        fetch('../index.php?page=penggajian?id=' + karyawanId)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                if (data.gaji_pokok !== undefined) {
                    document.getElementById('gaji_pokok').value = data.gaji_pokok;
                } else {
                    document.getElementById('gaji_pokok').value = 'Gaji pokok tidak tersedia';
                }
            })
            .catch(error => {
                console.error('Error fetching gaji pokok:', error);
                document.getElementById('gaji_pokok').value = 'Error';
            });
    } else {
        document.getElementById('gaji_pokok').value = '';
    }
}