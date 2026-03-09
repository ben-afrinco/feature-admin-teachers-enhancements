from django.test import TestCase
from django.urls import reverse

class IndexPageTest(TestCase):
    def test_index_page_status_code(self):
        response = self.client.get(reverse('core:index'))
        self.assertEqual(response.status_code, 200)

    def test_index_page_template(self):
        response = self.client.get(reverse('core:index'))
        self.assertTemplateUsed(response, 'core/index.html')
