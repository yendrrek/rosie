'use strict';

import { focusableElements } from './enabled-outline-for-keyboard-users.js';

export function hideOutline() {
  focusableElements().forEach(element => element.classList.add('outline-none'));
}
