/**
 * Client-side seek and speed enforcement.
 *
 * @module     mod_modernvideoplayer/enforcer
 * @copyright  2025 Adebare Showemmo | adebareshowemimo@gmail.com | support@agunfoninteractivity.com | www.agunfoninteractivity.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

const clampSeek = (video, state, strings) => {
    video.addEventListener('seeking', () => {
        if (typeof state.allowedposition !== 'number') {
            return;
        }

        if (video.currentTime > state.allowedposition) {
            video.currentTime = state.maxverifiedposition || 0;
            if (strings.seekblocked) {
                window.console.warn(strings.seekblocked);
            }
        }
    });
};

const clampSpeed = (video, state, strings) => {
    video.addEventListener('ratechange', () => {
        if (!state.allowplaybackspeed) {
            video.playbackRate = 1;
            return;
        }
        if (state.maxplaybackspeed && video.playbackRate > state.maxplaybackspeed) {
            video.playbackRate = state.maxplaybackspeed;
            if (strings.speedrestricted) {
                window.console.warn(strings.speedrestricted);
            }
        }
    });
};

export const init = (video, state, strings) => {
    clampSeek(video, state, strings);
    clampSpeed(video, state, strings);
};
