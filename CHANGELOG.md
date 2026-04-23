# Changelog

All notable changes to `mod_modernvideoplayer` are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Planned
- Captions (VTT) upload + CC button + transcript panel
- Chapters / timeline markers
- Learner-facing playback speed UI (0.5×–2×)
- Keyboard shortcuts + help modal
- Learner bookmarks

## [0.1.0] - 2026-04-22

Initial alpha release.

### Added
- HTML5 player: play / pause / mute / volume / fullscreen / Picture-in-Picture
- Poster image, focus mode, configurable nav toggle
- **Autoplay modes**: off / muted / unmuted (muted fallback on browser block)
- Server-side seek enforcement via signed session tokens
- Server-side playback-speed enforcement
- Heartbeat + segment-based progress tracking
- Suspicious-event counters
- Custom completion rule ("watched ≥ X %")
- Availability condition ("watched ≥ X %")
- Per-learner report with CSV export
- Moodle events: `progress_updated`, `completion_achieved`,
  `suspicious_seek_detected`
- External web services: `get_progress`, `heartbeat`, `mark_complete`,
  `reset_progress`
- Backup / restore
- Privacy provider (GDPR)
- Moodle App support
- Site-wide default settings (autoplay, fullscreen, speed, seek tolerance,
  completion threshold)

[Unreleased]: https://github.com/adebareshowemimo/modernvideoplayer/compare/v0.1.0...HEAD
[0.1.0]: https://github.com/adebareshowemimo/modernvideoplayer/releases/tag/v0.1.0
