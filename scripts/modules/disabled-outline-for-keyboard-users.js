'use strict';

import { focusableElements } from './enabled-outline-for-keyboard-users.js';

export function hideOutline() {
  for (const elements of focusableElements()) {
    elements.classList.add('outline-none');
  }
}
