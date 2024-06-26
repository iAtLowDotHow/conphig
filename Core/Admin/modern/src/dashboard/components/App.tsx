/**
 * External dependencies.
 */
import { Route, Routes, Navigate } from 'react-router-dom';
import { Toaster } from 'react-hot-toast';

/**
 * Internal dependencies.
 */
import { Dashboard, Onboarding, Changelog, Test } from './pages';
import { GeneralSettings, BlockSettings } from './pages/settings';

const App = () => {
    return (
        <>
            <Toaster position="bottom-center" />
            <Routes>
                <Route path="/dashboard" element={<Dashboard />} />
                <Route path="/getting-started" element={<Onboarding />} />
                <Route path="/changelog" element={<Changelog />} />
                <Route path="/settings" element={<GeneralSettings />} />
                <Route path="/block-settings" element={<BlockSettings />} />
                <Route path="/test" element={<Test />} />

                {/* When no routes match, it will redirect to this route path. Note that it should be registered above. */}
                <Route
                    path="*"
                    element={<Navigate to="/dashboard" replace />}
                />
            </Routes>
        </>
    )
}

export default App;