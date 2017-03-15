<?php

class QubeIn_Error extends Exception {}
class QubeIn_HttpError extends QubeIn_Error {}

/**
 * The parameters passed to the API call are invalid or not provided when required
 */
class QubeIn_ValidationError extends QubeIn_Error {}

/**
 * The provided API key is not a valid QubeIn API key
 */
class QubeIn_Invalid_Key extends QubeIn_Error {}
