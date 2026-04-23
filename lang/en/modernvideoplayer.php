<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Language strings for mod_modernvideoplayer.
 *
 * @package    mod_modernvideoplayer
 * @copyright  2025 Adebare Showemmo | adebareshowemimo@gmail.com | support@agunfoninteractivity.com | www.agunfoninteractivity.com
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Modern video player';
$string['pluginadministration'] = 'Modern video player administration';
$string['modulename'] = 'Modern video player';
$string['modulenameplural'] = 'Modern video players';
$string['modulename_help'] = 'Modern video player provides a controlled Moodle-native video activity with tracked playback progress.';
$string['modernvideoplayer:addinstance'] = 'Add a new modern video player activity';
$string['modernvideoplayer:view'] = 'View modern video player';
$string['modernvideoplayer:submitprogress'] = 'Submit modern video player progress';
$string['modernvideoplayer:viewreports'] = 'View modern video player reports';
$string['modernvideoplayer:manage'] = 'Manage modern video player settings';

$string['name'] = 'Activity name';
$string['video'] = 'Video file';
$string['posterimage'] = 'Poster image';
$string['videosettings'] = 'Video source';
$string['playbacksettings'] = 'Playback settings';
$string['enforcementsettings'] = 'Enforcement settings';
$string['focusmodesettings'] = 'Navigation & Drawers Settings';
$string['defaultshowsecondarynav'] = 'Default: show secondary navigation and page header';
$string['report'] = 'Learner progress report';
$string['reportheader'] = 'Learner progress';
$string['reporttotallearners'] = 'Total learners';
$string['reportcompletedlearners'] = 'Completed learners';
$string['reportcompletionrate'] = 'Completion rate';
$string['reportaveragecoverage'] = 'Average coverage';
$string['reportsuspiciousflags'] = 'Suspicious flags';
$string['reportintegrityfailures'] = 'Integrity failures';
$string['filtercompletion'] = 'Completion filter';
$string['filterall'] = 'All learners';
$string['filtercompleted'] = 'Completed only';
$string['filterincomplete'] = 'Incomplete only';
$string['filtersuspiciousonly'] = 'Suspicious activity only';
$string['filtersearch'] = 'Search learners';
$string['filterapply'] = 'Apply filters';
$string['novideo'] = 'No video file has been uploaded for this activity yet.';
$string['invalidvideo'] = 'The configured video could not be found.';
$string['resumeenabled'] = 'Allow resume';
$string['allowrewind'] = 'Allow rewind';
$string['allowfullscreen'] = 'Allow fullscreen';
$string['autoplay'] = 'Autoplay';
$string['autoplay_help'] = 'Controls whether the video starts playing automatically when the page loads.

* **Off** — The learner must press play.
* **Muted** — Playback begins automatically with audio muted. Most reliable across browsers.
* **Unmuted (muted fallback if blocked)** — Tries to start playback with sound. If the browser blocks it (most browsers block unmuted autoplay until the learner interacts with the page), playback automatically falls back to muted so the video still starts.

If the learner has a saved resume position, the resume prompt is shown instead and autoplay is suppressed until they choose.';
$string['autoplayoff'] = 'Off';
$string['autoplaymuted'] = 'Muted';
$string['autoplayunmuted'] = 'Unmuted (muted fallback if blocked)';
$string['showprimarynav'] = 'Show primary navigation bar';
$string['showprimarynav_help'] = 'When enabled, the top navigation bar is visible to learners while watching this video. When disabled, it is hidden to reduce distractions.

**Note:** This setting only affects the learner view. Site administrators and course managers always see the navigation bar when editing mode is on. To preview the learner experience, switch your role to Student.';
$string['showsecondarynav'] = 'Show secondary navigation and page header';
$string['showsecondarynav_help'] = 'When enabled, the secondary navigation tabs and the page header are visible to learners while watching this video. When disabled, they are hidden.

**Note:** This setting only affects the learner view. Site administrators and course managers always see these elements when editing mode is on. To preview the learner experience, switch your role to Student.';
$string['showcourseindex'] = 'Show course index drawer (left)';
$string['showcourseindex_help'] = 'When enabled, the course index drawer on the left side is visible to learners while watching this video. When disabled, it is hidden to keep focus on the video.

**Note:** This setting only affects the learner view. Site administrators and course managers always see the course index when editing mode is on. To preview the learner experience, switch your role to Student.';
$string['showrightblocks'] = 'Show right block drawer';
$string['showrightblocks_help'] = 'When enabled, the right-side block drawer is visible to learners while watching this video. When disabled, it is hidden.

**Note:** This setting only affects the learner view. Site administrators and course managers always see the block drawer when editing mode is on. To preview the learner experience, switch your role to Student.';
$string['titleposition'] = 'Video title position';
$string['titlepositionleft'] = 'Left';
$string['titlepositioncenter'] = 'Center';
$string['titlepositionright'] = 'Right';
$string['titlepositionhidden'] = 'Hidden';
$string['showcontroltext'] = 'Show text in player controls';
$string['allowplaybackspeed'] = 'Allow playback speed control';
$string['maxplaybackspeed'] = 'Maximum playback speed';
$string['requiredpercent'] = 'Required watch percentage';
$string['completionmode'] = 'Completion mode';
$string['completionmode_percent'] = 'Complete when required percentage is reached';
$string['completionmode_end'] = 'Complete only when end of video is validated';
$string['completionvideopercent'] = 'Require video watch percentage';
$string['completionvideopercentgroup'] = 'Require video watch percentage';
$string['completionvideopercentdesc'] = 'Learner must watch at least {$a}% of the video';
$string['completionvideoend'] = 'Require validated video ending';
$string['completionvideoenddesc'] = 'Learner must reach the validated end of the video';
$string['graceseconds'] = 'Forward seek grace seconds';
$string['heartbeatinterval'] = 'Heartbeat interval';
$string['forceservervalidation'] = 'Force server-side validation';
$string['strictendvalidation'] = 'Require end-of-video validation';
$string['showsuspiciousflags'] = 'Track suspicious activity flags';
$string['privacy:metadata'] = 'The Modern video player plugin stores learner playback progress.';
$string['privacy:metadata:modernvideoplayer_progress'] = 'Stores validated playback progress for a learner in a modern video player activity.';
$string['privacy:metadata:modernvideoplayer_progress:modernvideoplayerid'] = 'The activity instance identifier.';
$string['privacy:metadata:modernvideoplayer_progress:userid'] = 'The user whose progress is stored.';
$string['privacy:metadata:modernvideoplayer_progress:sessiontoken'] = 'The active playback session token.';
$string['privacy:metadata:modernvideoplayer_progress:duration'] = 'The last known duration of the video.';
$string['privacy:metadata:modernvideoplayer_progress:lastposition'] = 'The learner last confirmed playback position.';
$string['privacy:metadata:modernvideoplayer_progress:maxverifiedposition'] = 'The furthest server-validated playback position.';
$string['privacy:metadata:modernvideoplayer_progress:totalsecondswatched'] = 'The validated watched coverage in seconds.';
$string['privacy:metadata:modernvideoplayer_progress:percentcomplete'] = 'The validated watched coverage percentage.';
$string['privacy:metadata:modernvideoplayer_progress:completed'] = 'Whether the learner has completed the activity.';
$string['privacy:metadata:modernvideoplayer_progress:completiontime'] = 'The time the learner reached completion.';
$string['privacy:metadata:modernvideoplayer_progress:timecreated'] = 'The time the learner progress row was created.';
$string['privacy:metadata:modernvideoplayer_progress:lastheartbeat'] = 'The time of the most recent validated heartbeat.';
$string['privacy:metadata:modernvideoplayer_progress:lastplaybackrate'] = 'The most recently reported playback rate.';
$string['privacy:metadata:modernvideoplayer_progress:lastvisibility'] = 'The most recently reported tab visibility state.';
$string['privacy:metadata:modernvideoplayer_progress:suspiciousflags'] = 'The number of suspicious playback events recorded.';
$string['privacy:metadata:modernvideoplayer_progress:integrityfailures'] = 'The number of integrity failures recorded.';
$string['privacy:metadata:modernvideoplayer_segments'] = 'Stores merged, validated watched segments for a learner.';
$string['privacy:metadata:modernvideoplayer_segments:progressid'] = 'The progress record the segment belongs to.';
$string['privacy:metadata:modernvideoplayer_segments:segmentstart'] = 'The start of the validated watched segment.';
$string['privacy:metadata:modernvideoplayer_segments:segmentend'] = 'The end of the validated watched segment.';
$string['privacy:metadata:modernvideoplayer_segments:watchedseconds'] = 'The length of the validated watched segment.';
$string['privacy:metadata:modernvideoplayer_segments:timecreated'] = 'The time the segment was first recorded.';

$string['defaultrequiredpercent'] = 'Default required watch percentage';
$string['defaultheartbeatinterval'] = 'Default heartbeat interval';
$string['defaultgraceseconds'] = 'Default forward seek grace seconds';
$string['defaultallowplaybackspeed'] = 'Allow playback speed control by default';
$string['defaultmaxplaybackspeed'] = 'Default maximum playback speed';
$string['defaultresumeenabled'] = 'Enable resume by default';
$string['defaultfullscreenenabled'] = 'Enable fullscreen by default';
$string['defaultautoplay'] = 'Default autoplay mode';
$string['defaultshowprimarynav'] = 'Show primary navigation header by default';
$string['defaultshowcourseindex'] = 'Show course index drawer by default';
$string['defaultshowrightblocks'] = 'Show right block drawer by default';
$string['defaulttitleposition'] = 'Default video title position';
$string['defaultshowcontroltext'] = 'Show text in player controls by default';
$string['defaultsuspiciouslogging'] = 'Enable suspicious activity logging by default';

$string['eventprogressupdated'] = 'Playback progress updated';
$string['eventcompletionachieved'] = 'Playback completion achieved';
$string['eventsuspiciousseekdetected'] = 'Suspicious seek detected';
$string['eventplayerviewed'] = 'Modern video player viewed';

$string['playerlabel'] = 'Video player';
$string['progresslabel'] = 'Progress';
$string['bufferedlabel'] = 'Buffered';
$string['lastposition'] = 'Last position';
$string['maxverifiedposition'] = 'Max verified position';
$string['totalsecondswatched'] = 'Total watched seconds';
$string['percentcomplete'] = 'Percent complete';
$string['completed'] = 'Completed';
$string['completiontime'] = 'Completion time';
$string['suspiciousflags'] = 'Suspicious flags';
$string['lastheartbeat'] = 'Last heartbeat';
$string['duration'] = 'Duration';
$string['lastplaybackrate'] = 'Last playback rate';
$string['lastvisibility'] = 'Last visibility';
$string['integrityfailures'] = 'Integrity failures';
$string['fullname'] = 'Learner';
$string['email'] = 'Email';
$string['noentries'] = 'No learner progress has been recorded yet.';
$string['downloadcsv'] = 'Download CSV';
$string['downloadreportfilename'] = 'modern-video-player-report';
$string['yes'] = 'Yes';
$string['no'] = 'No';

$string['seekblocked'] = 'Forward seeking is limited until more of the video is verified as watched.';
$string['speedrestricted'] = 'The selected playback speed is not allowed for this activity.';
$string['progressunavailable'] = 'Progress data is not available.';
$string['play'] = 'Play';
$string['pause'] = 'Pause';
$string['mute'] = 'Mute';
$string['unmute'] = 'Unmute';
$string['rewind'] = 'Rewind';
$string['fullscreen'] = 'Fullscreen';
$string['resumeplayback'] = 'Resume watching';
$string['startfrombeginning'] = 'Start from beginning';
$string['resumeplaybackfrom'] = 'Resume from {$a}';
$string['resumepromptheading'] = 'Continue where you left off?';
$string['resumepromptbody'] = 'Pick up from your last verified point or restart from the beginning.';
