# Listening Proficiency Test

## Overview
Assesses auditory English comprehension through audio clips and comprehension questions.

## UI Components
- **Audio Player**: Control for listening to the passage (usually limited plays).
- **Selection List**: Multiple choice questions related to the audio.
- **Submit/Continue**: Flow control.

## Technical Implementation
- **Route**: `/test/listening/q1`, `/test/listening/{q}` (POST)
- **Controller**: `TestController@submitListening`
- **Feature**: Supports "Get Ready" interval and final "Done" state tracking.

## How to use from Browser
1. Reach the listening section of the exam.
2. Click "Play" on the audio clip.
3. Select answers based on what you heard.
4. Submit to continue.
