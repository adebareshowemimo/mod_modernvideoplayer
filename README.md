# Modern Video Player for Moodle (`mod_modernvideoplayer`)

[![Moodle Plugin CI](https://github.com/adebareshowemimo/modernvideoplayer/actions/workflows/moodle-ci.yml/badge.svg)](https://github.com/adebareshowemimo/modernvideoplayer/actions/workflows/moodle-ci.yml)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](LICENSE)
[![Moodle 4.5+](https://img.shields.io/badge/Moodle-4.5%2B-orange.svg)](https://moodle.org)
[![PHP 8.1+](https://img.shields.io/badge/PHP-8.1%2B-8892BF.svg)](https://www.php.net)

A **secure HTML5 video activity** for Moodle with **server-side seek and
playback-speed enforcement**, accurate segment-based progress tracking, and
first-class accessibility.

> Built for courses where watch-time is evidence — compliance training,
> micro-credentials, mandatory onboarding, flipped classrooms.

---

## Why this plugin

Moodle's built-in video embedding (via `mod_resource` or the URL filter) shows a
video. It doesn't tell you if the learner actually watched it. Skipping,
fast-forwarding, and tab-hiding all look like "watched".

`mod_modernvideoplayer` closes that gap:

- **Server-side enforcement.** Every seek and speed change is validated server
  side against a signed session token. Clients can't lie about watch state.
- **Segment-level progress.** Heartbeats record which intervals of the video
  were actually played, giving a real viewed-percentage — not the native
  `timeupdate` approximation.
- **Real completion.** Native Moodle completion rule "watched ≥ X%" and a
  matching availability condition for downstream activities.

## Features

### Playback
- Play / pause / mute / volume / fullscreen / Picture-in-Picture
- Poster image, focus mode, configurable nav toggle
- **Autoplay modes**: off / muted / unmuted (with muted fallback when the
  browser blocks sound)
- External URL or uploaded MP4

### Integrity (the differentiator)
- Signed session tokens per user + activity
- Server-side seek validation (configurable tolerance)
- Server-side playback-speed enforcement (allow / deny list)
- Suspicious-event counters + admin visibility

### Progress & completion
- Heartbeat + segment tracking → accurate viewed-percentage
- Custom completion rule: "watched at least N %"
- Availability condition: gate downstream activities on watch progress
- Resume from last position

### Reporting
- Per-activity learner report with progress, flags, last-seen, total watched
- CSV export
- Moodle events (`progress_updated`, `completion_achieved`,
  `suspicious_seek_detected`) for your favourite LRS / data warehouse

### Platform hygiene
- Full backup & restore
- Privacy provider (GDPR subject-access export + delete)
- Moodle App support
- Mustache templates, AMD modules, theme-aware

## Requirements

- Moodle **4.5+** or **5.0+**
- PHP **8.1+**
- Modern browser with HTML5 video support

## Install

### Via Moodle admin UI (recommended)

1. Download the latest release ZIP from the [Releases page](https://github.com/adebareshowemimo/modernvideoplayer/releases).
2. In Moodle, go to **Site administration → Plugins → Install plugins**.
3. Drop the ZIP into the uploader.
4. Confirm the plugin details and click **Install**. Run the upgrade.

### Via git

```bash
cd /path/to/moodle/mod
git clone https://github.com/adebareshowemimo/modernvideoplayer.git
# Then from Moodle root:
php admin/cli/upgrade.php
```

## Configuration

Site administration → Plugins → Activity modules → **Modern video player**.
You can set site-wide defaults for:

- Default autoplay mode (off / muted / unmuted)
- Fullscreen enabled by default
- Playback speed allowed
- Seek tolerance (seconds)
- Completion threshold (%)

## Instructor usage

1. Turn editing on in a course.
2. **Add an activity or resource → Modern video player**.
3. Upload an MP4 (or paste an external URL).
4. Set completion rule (e.g. watched ≥ 80 %) and save.

Learners get a clean player; instructors get a report at
*Course → Activity → Report*.

## Development

```bash
# AMD build
cd /path/to/moodle
npx grunt amd --root=mod/modernvideoplayer

# Unit tests
vendor/bin/phpunit --testsuite mod_modernvideoplayer_testsuite

# Behat (requires behat init)
vendor/bin/behat --tags=@mod_modernvideoplayer
```

## Roadmap (free edition)

See [plan-freeVersion.prompt.md](https://github.com/adebareshowemimo/modernvideoplayer/blob/main/docs/roadmap.md)
for the tracked roadmap. Highlights on the path to **1.0.0**:

- Captions (VTT) + transcript panel with click-to-seek
- Chapters / timeline markers
- Keyboard shortcuts + learner-facing speed menu
- Learner bookmarks
- Behat + PHPUnit coverage green on Moodle 4.5 and 5.0

## Contributing

Issues and PRs welcome! Please read
[CONTRIBUTING.md](CONTRIBUTING.md) first. All contributors sign a
[lightweight CLA](https://cla-assistant.io) so we can keep the project
relicensable if needed.

## Security

If you find a security issue, **please do not file a public issue.** Email
`security@agunfoninteractivity.com` instead. See [SECURITY.md](SECURITY.md).

## License

GPL-3.0-or-later. See [LICENSE](LICENSE).

## Commercial support & premium add-ons

The community edition is 100% free and GPL. Paid tiers (Pro / Enterprise) add
auto-captions, watermarking, signed URLs, interactive questions, heatmap
analytics, xAPI/LTI, DRM and SLA support. Contact
`sales@agunfoninteractivity.com` or see [the pricing page](https://agunfoninteractivity.com/modernvideoplayer).

## Credits

Built by [Adebare Showemimo](https://agunfoninteractivity.com) and
contributors.
