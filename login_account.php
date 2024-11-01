<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumni Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/react@18/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/babel-standalone@6/babel.min.js"></script>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, -apple-system, sans-serif; }
    </style>
</head>
<body class="bg-gray-50">
    <div id="root"></div>

    <script type="text/babel">
        function AuthPage() {
            const [isSignIn, setIsSignIn] = React.useState(true);

            return (
                <div className="min-h-screen flex items-center justify-center p-4">
                    <div className="w-full max-w-md bg-white rounded-xl shadow-lg p-8">
                        <h1 className="text-2xl font-bold text-center mb-2">Alumni Portal</h1>
                        <p className="text-center text-gray-600 mb-6">Welcome back to your alumni community</p>

                        {/* Toggle Buttons */}
                        <div className="flex gap-2 mb-6">
                            <button 
                                onClick={() => setIsSignIn(true)}
                                className={`flex-1 py-2 px-4 rounded-lg transition-colors ${
                                    isSignIn 
                                        ? 'bg-blue-600 text-white' 
                                        : 'bg-gray-100 text-gray-700'
                                }`}
                            >
                                Sign In
                            </button>
                            <button 
                                onClick={() => setIsSignIn(false)}
                                className={`flex-1 py-2 px-4 rounded-lg transition-colors ${
                                    !isSignIn 
                                        ? 'bg-blue-600 text-white' 
                                        : 'bg-gray-100 text-gray-700'
                                }`}
                            >
                                Sign Up
                            </button>
                        </div>

                        {/* Sign In Form */}
                        {isSignIn && (
                            <form action="login_process.php" method="POST" className="space-y-4">
                                <div>
                                    <input
                                        type="email"
                                        name="email"
                                        placeholder="Email"
                                        className="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <div>
                                    <input
                                        type="password"
                                        name="password"
                                        placeholder="Password"
                                        className="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <button
                                    type="submit"
                                    className="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    Sign In
                                </button>
                            </form>
                        )}

                        {/* Sign Up Form */}
                        {!isSignIn && (
                            <form action="register_process.php" method="POST" className="space-y-4">
                                <div>
                                    <input
                                        type="text"
                                        name="fullName"
                                        placeholder="Full Name"
                                        className="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <div>
                                    <input
                                        type="email"
                                        name="email"
                                        placeholder="Email"
                                        className="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <div>
                                    <input
                                        type="text"
                                        name="department"
                                        placeholder="Department"
                                        className="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <div>
                                    <input
                                        type="text"
                                        name="graduationYear"
                                        placeholder="Graduation Year"
                                        className="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <div>
                                    <input
                                        type="password"
                                        name="password"
                                        placeholder="Password"
                                        className="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        required
                                    />
                                </div>
                                <button
                                    type="submit"
                                    className="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    Sign Up
                                </button>
                            </form>
                        )}

                        <p className="text-center text-sm text-gray-600 mt-6">
                            Protected by reCAPTCHA and subject to our Privacy Policy
                        </p>
                    </div>
                </div>
            );
        }

        const root = ReactDOM.createRoot(document.getElementById('root'));
        root.render(<AuthPage />);
    </script>
</body>
</html>