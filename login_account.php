<?php
// index.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Portal</title>
    <!-- Include React and ReactDOM from CDN for development -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/18.2.0/umd/react.development.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react-dom/18.2.0/umd/react-dom.development.js"></script>
    <!-- Include Babel for JSX transformation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/7.23.5/babel.min.js"></script>
    <!-- Include Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div id="root"></div>
    <!-- Your React component will be mounted here -->
    <script type="text/babel">
        // Import your React component here
        const AuthPages = () => {
            const [loading, setLoading] = React.useState(false);

            const handleSignIn = async (e) => {
                e.preventDefault();
                setLoading(true);
                
                const formData = new FormData(e.target);
                try {
                    const response = await fetch('auth.php', {
                        method: 'POST',
                        body: formData
                    });
                    // Handle response
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    setLoading(false);
                }
            };

            const handleSignUp = async (e) => {
                e.preventDefault();
                setLoading(true);
                
                const formData = new FormData(e.target);
                try {
                    const response = await fetch('register.php', {
                        method: 'POST',
                        body: formData
                    });
                    // Handle response
                } catch (error) {
                    console.error('Error:', error);
                } finally {
                    setLoading(false);
                }
            };

            return (
                <div className="min-h-screen bg-gray-100 flex items-center justify-center p-4">
                    <div className="w-full max-w-md bg-white rounded-lg shadow-md p-6">
                        <h1 className="text-2xl font-bold text-center mb-2">Alumni Portal</h1>
                        <p className="text-center text-gray-600 mb-6">Welcome back to your alumni community</p>
                        
                        <div className="mb-6">
                            <div className="flex space-x-2 mb-6">
                                <button 
                                    className="flex-1 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                    onClick={() => document.getElementById('signinForm').style.display = 'block'}
                                >
                                    Sign In
                                </button>
                                <button 
                                    className="flex-1 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors"
                                    onClick={() => document.getElementById('signupForm').style.display = 'block'}
                                >
                                    Sign Up
                                </button>
                            </div>

                            <form id="signinForm" onSubmit={handleSignIn} className="space-y-4">
                                <div>
                                    <input
                                        type="email"
                                        name="email"
                                        placeholder="Email"
                                        required
                                        className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    />
                                </div>
                                <div>
                                    <input
                                        type="password"
                                        name="password"
                                        placeholder="Password"
                                        required
                                        className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    />
                                </div>
                                <button
                                    type="submit"
                                    disabled={loading}
                                    className="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    {loading ? 'Signing in...' : 'Sign In'}
                                </button>
                            </form>

                            <form id="signupForm" onSubmit={handleSignUp} className="space-y-4" style={{display: 'none'}}>
                                <div>
                                    <input
                                        type="text"
                                        name="fullName"
                                        placeholder="Full Name"
                                        required
                                        className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    />
                                </div>
                                <div>
                                    <input
                                        type="email"
                                        name="email"
                                        placeholder="Email"
                                        required
                                        className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    />
                                </div>
                                <div>
                                    <input
                                        type="text"
                                        name="department"
                                        placeholder="Department"
                                        required
                                        className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    />
                                </div>
                                <div>
                                    <input
                                        type="text"
                                        name="graduationYear"
                                        placeholder="Graduation Year"
                                        required
                                        className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    />
                                </div>
                                <div>
                                    <input
                                        type="password"
                                        name="password"
                                        placeholder="Password"
                                        required
                                        className="w-full px-4 py-2 border rounded-lg focus:outline-none focus:border-blue-500"
                                    />
                                </div>
                                <button
                                    type="submit"
                                    disabled={loading}
                                    className="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    {loading ? 'Signing up...' : 'Sign Up'}
                                </button>
                            </form>
                        </div>
                        
                        <p className="text-center text-sm text-gray-600">
                            Protected by reCAPTCHA and subject to our Privacy Policy
                        </p>
                    </div>
                </div>
            );
        };

        // Mount the React component
        const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<AuthPages />);
    </script>
</body>
</html>