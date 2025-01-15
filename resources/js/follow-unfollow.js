function helper_follow(userId, username) {
    return new Promise((resolve, reject) => {
        const formData = new FormData();
        formData.append('user_id', userId);

        fetch(`/users/${username}/follow`, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData,
        })
        .then(_ => resolve());
    });
}

function helper_unfollow(userId, username) {
    return new Promise((resolve, reject) => {
        const formData = new FormData();
        formData.append('user_id', userId);

        fetch(`/users/${username}/unfollow`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => console.log(data), resolve());
    });
}